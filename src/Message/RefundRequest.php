<?php

namespace Corals\Modules\Payment\Mojopay\Message;

use Corals\Modules\Payment\Common\Exception\InvalidRequestException;
use Money\Currency;

/**
 * Mojopay  Capture Authorization  Request
 *
 */
class RefundRequest extends AbstractRequest
{
    /**
     * @var string;
     */
    protected $requestName = 'UAPIRequest';


    /**
     * Validate and construct the data for the request
     *
     * @return array
     */

    public function getData()
    {
        $this->validate('transactionId', 'amount', 'orderid');


        $transaction = ['process' => 'online', 'type' => 'capture'];


        $data = [
            'transaction' => $transaction,
            'requestData' => [
                'uapiTransactionId' => $this->getTransactionId(),
                'orderId' => $this->getOrderId(),
                'orderAmount' => $this->getAmount(),
            ]
        ];

        return $data;
    }


    /**
     * Return the authorize response object
     *
     * @param \SimpleXMLElement $xml Response xml object
     *
     * @return RefundResponse
     */
    protected function newResponse($xml)
    {
        return new RefundResponse($this, $xml);
    }

}
