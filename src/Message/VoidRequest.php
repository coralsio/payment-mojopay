<?php

namespace Corals\Modules\Payment\Mojopay\Message;

use Corals\Modules\Payment\Common\Exception\InvalidRequestException;
use Money\Currency;

/**
 * Mojopay  Void Authorization  Request
 *
 */
class VoidRequest extends AbstractRequest
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
        $this->validate('transactionId', 'amount');


        $transaction = ['process' => 'online', 'type' => 'void'];


        $data = [
            'transaction' => $transaction,
            'requestData' => [
                'uapiTransactionId' => $this->getTransactionId(),
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
     * @return VoidResponse
     */
    protected function newResponse($xml)
    {
        return new VoidResponse($this, $xml);
    }

}
