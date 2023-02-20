<?php

namespace Corals\Modules\Payment\Mojopay\Message;

use Corals\Modules\Payment\Common\Exception\InvalidRequestException;
use Money\Currency;

/**
 * Mojopay  Authorize Request
 *
 * Required Parameters:
 * amount - Float ex. "10.00",
 * currency - Currency code ex. "USD",*
 * There are also 2 optional boolean parameters outside of the normal Omnipay parameters:
 * requireAVSCheck - will tell Mojopay that we want the to verify the address through AVS
 * createCard - will tell Mojopay to create a tokenized card in their system while it is authorizing the transaction
 */
class PurchaseRequest extends AbstractRequest
{
    /**
     * @var string;
     */
    protected $requestName = 'UAPIRequest';
    protected $transactionType;


    /**
     * Validate and construct the data for the request
     *
     * @return array
     */
    public function getData()
    {
        $this->validate('transactionId', 'amount', 'currency', 'card', 'billing', 'shipping');


        $this->getCard()->validate();

        $cardDetails = [
            'cardCVV' => $this->getCard()->getCvv(),
            'cardExpiration' => $this->getCard()->getExpiryDate('my'),
            'cardNumber' => $this->getCard()->getNumber(),
        ];

        $transaction = ['process' => 'online', 'type' => $this->transactionType];


        $data = [
            'transaction' => $transaction,
            'requestData' => [
                'orderId' => $this->getTransactionId(),
                'orderAmount' => $this->getAmount(),
                'currencyCode' => '840',
                'orderDescription' => $this->getDescription(),
                'card' => $cardDetails,
                'billing' => $this->getBilling(),
                'shipping' => $this->getShipping()
            ]
        ];

        return $data;
    }


    /**
     * Returns the transaction code based on the AVS check requirement
     *
     * @return int Transaction Code
     */
    protected function getTransactionCode()
    {
        $transactionCode = $this->transactionCode;
        if ($this->getRequireAvsCheck()) {
            $transactionCode += 1;
        }
        if ($this->getCreateCard()) {
            $transactionCode += 128;
        }
        return $transactionCode;
    }

    /**
     * Return the authorize response object
     *
     * @param \SimpleXMLElement $xml Response xml object
     *
     * @return PurchaseResponse
     */
    protected function newResponse($xml)
    {
        return new PurchaseResponse($this, $xml);
    }

    /**
     * @param boolean $value Create a tokenized card on Mojopay during an authorize request
     *
     * @return \Corals\Modules\Payment\Common\Message\AbstractRequest
     */
    public function setCreateCard($value)
    {
        return $this->setParameter('createCard', $value);
    }

    /**
     * @return boolean Create a tokenized card on Mojopay during an authorize request
     */
    public function getCreateCard()
    {
        return $this->getParameter('createCard');
    }
}
