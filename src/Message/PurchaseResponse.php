<?php

namespace Corals\Modules\Payment\Mojopay\Message;

use Corals\Modules\Payment\Common\Exception\InvalidResponseException;
use Corals\Modules\Payment\Common\Message\RequestInterface;
use Corals\Modules\Payment\Mojopay\Message\AbstractResponse;

/**
 * Mojo XML Authorize Response
 */
class PurchaseResponse extends AbstractResponse
{
    /**
     * Constructor
     *
     * @param RequestInterface $request
     * @param string $data
     */
    public function __construct(RequestInterface $request, $data)
    {
        if (empty($data)) {
            throw new InvalidResponseException();
        }

        $this->request = $request;
        $this->data = $this->xmlDeserialize($data);

    }




    /**
     * Return the response's reason code
     *
     * @return string
     */
    public function getCode()
    {
        return isset($this->data['processorResponseCode']) ? $this->data['processorResponseCode'] : null;
    }

    /**
     * Return the response's reason message
     *
     * @return string
     */
    public function getMessage()
    {
        return isset($this->data['processorResponse']) ? $this->data['processorResponse'] : $this->data['statusMessage'];
    }

    /**
     * Return transaction reference
     *
     * @return string
     */
    public function getTransactionReference()
    {
        return isset($this->data['transactionId']) ? $this->data['transactionId'] : null;
    }

    /**
     * If the createCard parameter is set to true on the authorize request this will return the token
     *
     * @return string|null
     */
    public function getCardReference()
    {
        return isset($this->data['UAPIResponse']['token']) ? $this->data['UAPIResponse']['token'] : null;
    }
}
