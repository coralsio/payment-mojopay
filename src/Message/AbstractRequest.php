<?php

namespace Corals\Modules\Payment\Mojopay\Message;

use Corals\Modules\Payment\Common\Message\AbstractRequest as BaseAbstractRequest;
use Corals\Modules\Payment\Common\Message\ResponseInterface;
use Corals\Modules\Payment\Fac\CreditCard;
use SimpleXMLElement;

abstract class AbstractRequest extends BaseAbstractRequest
{

    /**
     * Mojopay live endpoint URL
     *
     * @var string
     */
    protected $liveEndpoint = 'https://uapi.mojopay.com/universalapi';

    /**
     * MojopayPG2 test endpoint URL
     *
     * @var string
     */
    protected $testEndpoint = 'https://apidev.mojopay.com/universalapi';

    /**
     * MojopayPG2 XML namespace
     *
     * @var string
     */
    protected $namespace = '';

    /**
     * MojopayPG2 XML root
     *
     * @var string
     */
    protected $requestName = '';


    /**
     * Returns the amount formatted to match Mojopay's expectations.
     *
     * @return string The amount padded with zeros on the left to 12 digits and no decimal place.
     */
    protected function formatAmount()
    {
        $amount = $this->getAmount();

        $amount = str_replace('.', '', $amount);
        $amount = str_pad($amount, 12, '0', STR_PAD_LEFT);

        return $amount;
    }

    public function getShipping()
    {
        return $this->getParameter('shipping');
    }

    public function setShipping($value)
    {
        return $this->setParameter('shipping', $value);
    }

    public function getBilling()
    {
        return $this->getParameter('billing');
    }

    public function setBilling($value)
    {
        return $this->setParameter('billing', $value);
    }


    /**
     * Returns the live or test endpoint depending on TestMode.
     *
     * @return string Endpoint URL
     */
    protected function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    /**
     * Return the response object
     *
     * @param \SimpleXMLElement $xml Response xml object
     *
     * @return ResponseInterface
     */
    abstract protected function newResponse($xml);

    /**
     * Send the request payload
     *
     * @param array $data Request payload
     *
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        $httpResponse = $this->httpClient->request('POST',
            $this->getEndpoint(),
            ['Content-Type' => 'application/xml', 'authorized' => $this->getAPIKey()],
            $this->xmlSerialize($data)
        );

        return $this->response = $this->newResponse((string)$httpResponse->getBody()->getContents());
    }

    /**
     * Serializes an array into XML
     *
     * @param array $data Array to serialize into XML.
     * @param \SimpleXMLElement $xml SimpleXMLElement object.
     *
     * @return string XML
     */
    protected function xmlSerialize($data, $xml = null)
    {
        if (!$xml instanceof SimpleXMLElement) {
            $xml = new SimpleXMLElement('<' . $this->requestName . '/>');
        }

        foreach ($data as $key => $value) {
            if (!isset($value)) {
                continue;
            }

            if (is_array($value)) {
                $node = $xml->addChild($key);
                $this->xmlSerialize($value, $node);
            } else {
                $xml->addChild($key, $value);
            }
        }

        return $xml->asXML();
    }

    /**
     * Sets the card.
     *
     * @param CreditCard $value
     *
     * @return \Corals\Modules\Payment\Common\Message\AbstractRequest Provides a fluent interface
     */
    public function setCard($value)
    {
        if ($value && !$value instanceof CreditCard) {
            $value = new \Corals\Modules\Payment\Common\CreditCard($value);
        }

        return $this->setParameter('card', $value);
    }

    /**
     * Get the card.
     *
     * @return CreditCard
     */
    public function getCard()
    {
        return $this->getParameter('card');
    }

    /**
     * Getter: Mojopay public key.
     *
     * @return string
     */
    public function getAPIKey()
    {
        return $this->getParameter('APIKey');
    }

    /**
     * Setter: Mojopay public key.
     *
     * @param $value
     *
     * @return $this
     */
    public function setAPIKey($value)
    {
        return $this->setParameter('APIKey', $value);
    }

    public function getOrderId()
    {
        return $this->getParameter('orderid');
    }

    public function setOrderId($value)
    {
        return $this->setParameter('orderid', $value);
    }

}
