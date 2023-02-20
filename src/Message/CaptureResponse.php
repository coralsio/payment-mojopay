<?php

namespace Corals\Modules\Payment\Mojopay\Message;

use Corals\Modules\Payment\Common\Exception\InvalidResponseException;
use Corals\Modules\Payment\Common\Message\RequestInterface;
use Corals\Modules\Payment\Mojopay\Message\AbstractResponse;

/**
 * Mojo XML Authorize Response
 */
class CaptureResponse extends AbstractResponse
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
        return isset($this->data['statusCode']) ? $this->data['statusCode'] : null;
    }

    /**
     * Return the response's reason message
     *
     * @return string
     */
    public function getMessage()
    {
        return isset($this->data['statusMessage']) ? $this->data['statusMessage'] : null;
    }

    /**
     * Return transaction reference
     *
     * @return string
     */
    public function getTransactionReference()
    {
        return isset($this->data['processorTransactionID']) ? $this->data['processorTransactionID'] : null;
    }


}
