<?php

namespace Corals\Modules\Payment\Mojopay\Message;

use Corals\Modules\Payment\Common\Exception\InvalidRequestException;
use Money\Currency;

/**
 * Mojopay  Capture Authorization  Request
 *
 */
class CaptureRequest extends AbstractRequest
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


        $transaction = ['process' => 'online', 'type' => 'capture'];


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
     * @return CaptureResponse
     */
    protected function newResponse($xml)
    {
        return new CaptureResponse($this, $xml);
    }

}
