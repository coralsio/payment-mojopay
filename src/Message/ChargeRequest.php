<?php

namespace Corals\Modules\Payment\Mojopay\Message;


class ChargeRequest extends PurchaseRequest
{
    protected $transactionType = 'sale';

    /**
     * Return the authorize response object
     *
     * @param \SimpleXMLElement $xml Response xml object
     *
     * @return PurchaseResponse
     */
    protected function newResponse($xml)
    {
        return new ChargeResponse($this, $xml);
    }
}
