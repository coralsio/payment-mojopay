<?php

namespace Corals\Modules\Payment\Mojopay\Message;


class AuthorizationRequest extends PurchaseRequest
{
    protected $transactionType = 'authorization';


    /**
     * Return the authorize response object
     *
     * @param \SimpleXMLElement $xml Response xml object
     *
     * @return PurchaseResponse
     */
    protected function newResponse($xml)
    {
        return new AuthorizationResponse($this, $xml);
    }
}
