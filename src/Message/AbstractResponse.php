<?php

namespace Corals\Modules\Payment\Mojopay\Message;

use Corals\Modules\Payment\Common\Message\AbstractResponse as BaseAbstractResponse;
use SimpleXMLElement;

abstract class AbstractResponse extends BaseAbstractResponse
{
    /**
     * Seserializes XML to an array
     *
     * @param \SimpleXMLElement|string $xml SimpleXMLElement object or a well formed xml string.
     *
     * @return array data
     */

    protected $responseCodesHumanReadable = array(
        000 => 'Approved',
        010 => 'Partially Approved',
        110 => 'Insufficient Funds',
        111 => 'Authorization amount has already been depleted',
        127 => 'Exceeds Approval Amount Limit',
        140 => 'Update Cardholder Data',
        191 => 'The merchant is not registered in the update program.',
        192 => 'Merchant not certified/enabled for IIAS',
        206 => 'Issuer Generated Error',
        207 => 'Pickup card - Other than Lost/Stolen',
        209 => 'Invalid Amount',
        215 => 'Restricted Card',
        216 => 'Invalid Deactivate',
        218 => 'Card Not Active',
        219 => 'Card Already Deactivate',
        213 => 'Lost Card - Pick Up',
        214 => 'Stolen Card - Pick Up',
        221 => 'Over Max Balance',
        222 => 'Invalid Activate',
        226 => 'Incorrect CVV',
        229 => 'Illegal Transaction',
        251 => 'Duplicate Transactions',
        252 => 'System Error',
        254 => 'Merchant Depleted',
        257 => 'System Error',
        258 => 'System Error',
        301 => 'Invalid Account Number',
        302 => 'Account Number Does Not Match Payment Type',
        303 => 'Pick Up Card',
        304 => 'Lost/Stolen Card',
        305 => 'Expired Card',
        306 => 'Authorization has expired; no need to reverse',
        307 => 'Restricted Card',
        308 => 'Restricted Card - Chargeback',
        320 => 'Invalid Expiration Date',
        321 => 'Invalid Merchant',
        322 => 'Invalid Transaction',
        323 => 'No such issuer',
        324 => 'Invalid Pin',
        325 => 'Transaction not allowed at terminal',
        326 => 'Exceeds number of PIN entries',
        327 => 'Cardholder transaction not permitted',
        328 => 'Cardholder requested that recurring or installment payment be stopped',
        330 => 'Invalid Payment Type',
        340 => 'Invalid Amount',
        361 => 'Authorization no longer available',
        708 => 'Invalid Data',
        712 => 'Duplicate transaction',
        713 => 'Verify billing address',
        714 => 'Inactive Account'
    );

    protected function xmlDeserialize($xml)
    {
        $array = [];

        if (!$xml instanceof SimpleXMLElement) {
            $xml = new SimpleXMLElement($xml);
        }

        foreach ($xml->children() as $key => $child) {
            $value = (string)$child;
            $_children = $this->xmlDeserialize($child);
            $_push = ($_hasChild = (count($_children) > 0)) ? $_children : $value;

            if ($_hasChild && !empty($value) && $value !== '') {
                $_push[] = $value;
            }

            $array[$key] = $_push;
        }

        return $array;
    }

    /**
     * This is mostly for convenience so you can get the Transaction ID from the response which FAC sends back with all
     * of their responses except the Create Card. If you call this from CreateCardResponse, you will just get a null.
     *
     * @return null
     */
    public function getTransactionId()
    {
        return isset($this->data['OrderNumber']) ? $this->data['OrderNumber'] : null;
    }

    public function getChargeReference()
    {
        return $this->getTransactionReference() ?: $this->getTransactionId();
    }

    /**
     * Return whether or not the response was successful
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return isset($this->data['statusMessage']) && 'Valid Format' === $this->data['statusMessage'] && isset($this->data['processorResponseCode']) && '000' === $this->data['processorResponseCode'];
    }
}
