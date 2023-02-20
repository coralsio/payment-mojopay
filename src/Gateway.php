<?php

namespace Corals\Modules\Payment\Mojopay;

use Corals\Modules\Payment\Common\AbstractGateway;
use Corals\Modules\Payment\Common\Models\WebhookCall;
use Corals\Modules\Subscriptions\Models\Plan;
use Corals\Modules\Subscriptions\Models\Subscription;
use Corals\User\Models\User;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use LVR\CreditCard\CardCvc;
use LVR\CreditCard\CardExpirationMonth;
use LVR\CreditCard\CardExpirationYear;
use LVR\CreditCard\CardNumber;

/**
 * Mojopay Gateway.
 */
class Gateway extends AbstractGateway
{
    use ValidatesRequests;

    public function getName()
    {
        return 'Mojopay';
    }

    public function setAuthentication()
    {
        $api_key = '';


        $sandbox = \Settings::get('payment_mojopay_sandbox_mode', 'true');

        if ($sandbox == 'true') {
            $this->setTestMode(true);
            $api_key = \Settings::get('payment_mojopay_sandbox_api_key');
        } elseif ($sandbox == 'false') {
            $this->setTestMode(false);
            $api_key = \Settings::get('payment_mojopay_live_api_key');
        }
        $this->setAPIKey($api_key);
    }

    public function getDefaultParameters()
    {
        return array(
            // if true, transaction with the live checkout URL will be a demo sale and card won't be charged.
            'demoMode' => false,
            'testMode' => false,
        );
    }

    /**
     * Getter: demo mode.
     *
     * @return string
     */
    public function getDemoMode()
    {
        return $this->getParameter('demoMode');
    }

    /**
     * Setter: demo mode.
     *
     * @param $value
     *
     * @return $this
     */
    public function setDemoMode($value)
    {
        return $this->setParameter('demoMode', $value);
    }

    /**
     * Getter: checkout language.
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->getParameter('language');
    }

    /**
     * Setter: checkout language.
     *
     * @param $value
     *
     * @return $this
     */
    public function setLanguage($value)
    {
        return $this->setParameter('language', $value);
    }

    /**
     * Getter: purchase step.
     *
     * @param $value
     *
     * @return $this
     */
    public function getPurchaseStep()
    {
        return $this->getParameter('purchaseStep');
    }

    /**
     * Setter: purchase step.
     *
     * @param $value
     *
     * @return $this
     */
    public function setPurchaseStep($value)
    {
        return $this->setParameter('purchaseStep', $value);
    }

    /**
     * Getter: coupon.
     *
     * @return string
     */
    public function getCoupon()
    {
        return $this->getParameter('coupon');
    }

    /**
     * Setter: coupon.
     *
     * @param $value
     *
     * @return $this
     */
    public function setCoupon($value)
    {
        return $this->setParameter('coupon', $value);
    }

    /**
     * Getter: Mojopay account number.
     *
     * @return string
     */
    public function getAccountNumber()
    {
        return $this->getParameter('accountNumber');
    }

    /**
     * Setter: Mojopay account number.
     *
     * @param $value
     *
     * @return $this
     */
    public function setAccountNumber($value)
    {
        return $this->setParameter('accountNumber', $value);
    }

    /**
     * Getter: Mojopay secret word.
     *
     * @return string
     */
    public function getSecretWord()
    {
        return $this->getParameter('secretWord');
    }

    /**
     * Setter: Mojopay secret word.
     *
     * @param $value
     *
     * @return $this
     */
    public function setSecretWord($value)
    {
        return $this->setParameter('secretWord', $value);
    }

    /**
     * Setter: sale ID for use by refund.
     *
     * @param $value
     *
     * @return $this
     */
    public function setSaleId($value)
    {
        return $this->setParameter('saleId', $value);
    }

    /**
     * Getter: sale ID for use by refund.
     *
     * @return string
     */
    public function getSaleId()
    {
        return $this->getParameter('saleId');
    }

    /**
     * Setter: sale ID for use by refund.
     *
     * @param $value
     *
     * @return $this
     */
    public function setInvoiceId($value)
    {
        return $this->setParameter('invoiceId', $value);
    }

    /**
     * Getter: sale ID for use by refund.
     *
     * @return string
     */
    public function getInvoiceId()
    {
        return $this->getParameter('invoiceId');
    }


    /**
     * Getter: category for use by refund.
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->getParameter('category');
    }

    /**
     * Setter: category for use by refund.
     *
     * @param $value
     *
     * @return $this
     */
    public function setCategory($value)
    {
        return $this->setParameter('category', $value);
    }

    /**
     * Getter: comment for use by refund.
     *
     * @return string
     */
    public function getComment()
    {
        return $this->getParameter('comment');
    }

    /**
     * Setter: category for use by refund.
     *
     * @param $value
     *
     * @return $this
     */
    public function setComment($value)
    {
        return $this->setParameter('comment', $value);
    }

    /**
     * Setter: lineitem_id for use by stop recurring.
     *
     * @param $value
     *
     * @return $this
     */
    public function setLineItemId($value)
    {
        return $this->setParameter('lineItemId', $value);
    }

    /**
     * Getter: lineitem_id for use by stop recurring.
     *
     * @return string
     */
    public function getLineItemId()
    {
        return $this->getParameter('lineItemId');
    }

    public function getAmount()
    {
        return $this->getParameter('amount');
    }

    public function setAmount($value)
    {
        return parent::setParameter('amount', $value);
    }

    public function getCurrency()
    {
        return parent::getCurrency();
    }

    public function setCurrency($value)
    {
        return parent::setCurrency($value);
    }

    /**
     * Setter: admin password for use by refund.
     *
     * @param $value
     *
     * @return $this
     */
    public function setAdminPassword($value)
    {
        return $this->setParameter('adminPassword', $value);
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


    /**
     * @param array $parameters
     *
     * @return \Corals\Modules\Payment\Common\Message\AbstractRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Mojopay\Message\PurchaseRequest', $parameters);
    }

    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Mojopay\Message\RefundRequest', $parameters);
    }


    /**
     * Create Subscription
     *
     * @param array $parameters
     * @return \Corals\Modules\Payment\Mojopay\Message\TokenPurchaseRequest
     */
    public function createSubscription(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Mojopay\Message\TokenPurchaseRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Corals\Modules\Payment\Common\Message\AbstractRequest
     */
    public function acceptNotification(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Mojopay\Message\NotificationRequest', $parameters);
    }

    public function getPaymentViewName($type = null)
    {
        if ($type == "subscription") {
            return "Mojopay::subscription-checkout";
        } else {
            if ($type == "ecommerce") {
                return "Mojopay::ecommerce-checkout";
            }
        }
    }

    /**
     * @param Plan $plan
     * @param User $user
     * @param Subscription|null $subscription
     * @return array
     * @throws Exception
     **/
    public function prepareSubscriptionParameters(
        Plan $plan,
        User $user,
        Subscription $subscription = null,
        $subscription_data = null
    ) {
        $parameters['cart'] = [
            [
                'type' => 'product',
                'name' => $plan->product->name,
                'price' => $plan->price,
                'recurrence' => $plan->bill_frequency . ' ' . ucfirst($plan->bill_cycle),
                'duration' => 'Forever',
            ]
        ];
        $parameters['amount'] = $plan->price;
        $parameters['transactionId'] = $user->id;
        $parameters['token'] = session()->get('checkoutToken');
        $parameters['accountNumber'] = $this->getAccountNumber();
        $parameters['privateKey'] = $this->getPrivateKey();
        $parameters['currency'] = \Payments::admin_currency_code();
        $parameters['billingAddr'] = array(
            "name" => 'Testing Tester',
            "addrLine1" => '123 Test St',
            "city" => 'Columbus',
            "state" => 'OH',
            "zipCode" => '43123',
            "country" => 'USA',
            "email" => 'testingtester@2co.com',
            "phoneNumber" => '555-555-5555'
        );
        session()->forget('checkoutToken');


        return $parameters;
    }

    public function prepareSubscriptionCancellationParameters(User $user, Subscription $current_subscription)
    {
        list($sale_id, $line_item_id) = explode('|', $current_subscription->subscription_reference);
        $parameters = [
            'adminUsername' => $this->getAdminUsername(),
            'adminPassword' => $this->getAdminPassword(),
            'lineItemId' => $line_item_id,
        ];

        return $parameters;
    }

    public static function webhookHandler(Request $request)
    {
        try {
            $webhookCall = null;


            $eventPayload = $request->input();
            $data = [
                'event_name' => 'mojopay.' . $eventPayload['message_type'],
                'payload' => $eventPayload,
                'gateway' => 'Mojopay'
            ];
            $webhookCall = WebhookCall::create($data);

            $webhookCall->process();
            die();
        } catch (\Exception $exception) {
            if ($webhookCall) {
                $webhookCall->saveException($exception);
            }
            log_exception($exception, 'Webhooks', 'mojopay');
        }
    }

    public function prepareCreateChargeParameters($order, User $user, $checkoutDetails)
    {
        $billingDetails = $checkoutDetails['billing_address'];
        $billing = [
            'billingAddressLine1' => $billingDetails['address_1'],
            'billingZipCode' => $billingDetails['zip'],
            'billingFirstName' => $billingDetails['first_name'],
            'billingLastName' => $billingDetails['last_name'],
            'billingCity' => $billingDetails['city'],
            'billingCountry' => $billingDetails['country'],
            'billingEmail' => $billingDetails['email'],
            'billingPhone' => $billingDetails['phone'] ?? '',
            'billingState' => substr($billingDetails['state'], 0, 2)
        ];

        $shippingDetails = $checkoutDetails['shipping_address'];
        $shipping = [
            'shippingAddressLine1' => $shippingDetails['address_1'],
            'shippingZipCode' => $shippingDetails['zip'],
            'shippingFirstName' => $shippingDetails['first_name'],
            'shippingLastName' => $shippingDetails['last_name'],
            'shippingCity' => $shippingDetails['city'],
            'shippingCountry' => $shippingDetails['country'],
            'shippingEmail' => $shippingDetails['email'] ?? $billingDetails['email'],
            'shippingPhone' => $shippingDetails['phone'] ?? '',
            'shippingState' => substr($shippingDetails['state'], 0, 2)
        ];

        return [
            'amount' => $order->amount,
            'currency' => strtolower($order->currency),
            'token' => $checkoutDetails['token'],
            'description' => 'Order #' . $order->id,
            'transactionId' => $order->order_number,
            'card' => $checkoutDetails['payment_details'],
            'billing' => $billing,
            'shipping' => $shipping
        ];
    }

    /**
     * create Charge
     *
     * @param array $parameters
     * @return \Corals\Modules\Payment\Mojopay\Message\
     */
    public function createCharge(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Mojopay\Message\ChargeRequest', $parameters);
    }

    /**
     * Capture Authorization
     *
     * @param array $parameters
     * @return \Corals\Modules\Payment\Mojopay\Message\
     */
    public function captureAuthorization(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Mojopay\Message\CaptureRequest', $parameters);
    }


    /**
     * Void Authorization
     *
     * @param array $parameters
     * @return \Corals\Modules\Payment\Mojopay\Message\
     */
    public function voidAuthorization(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Mojopay\Message\VoidRequest', $parameters);
    }


    public function validateRequest($request)
    {
        return $this->validate($request, [
            'payment_details.number' => ['required', new CardNumber()],
            'payment_details.expiryYear' => [
                'required',
                new CardExpirationYear($request->input('payment_details.expiryMonth', ''))
            ],
            'payment_details.expiryMonth' => [
                'required',
                new CardExpirationMonth($request->input('payment_details.expiryYear', ''))
            ],
            'payment_details.cvv' => [
                'required',
                new CardCvc($request->input('payment_details.number', ''))
            ],
        ], [], [
            'payment_details.number' => trans('Mojopay::attributes.card_number'),
            'payment_details.expiryYear' => trans('Mojopay::attributes.expYear'),
            'payment_details.expiryMonth' => trans('Mojopay::attributes.expMonth'),
            'payment_details.cvv' => trans('Mojopay::attributes.cvv'),
        ]);
    }

    public function prepareCreateRefundParameters($order, $amount)
    {
        return [
            'amount' => $amount,
            'orderid' => $order->order_number,
            'transactionId' => $order->billing['payment_reference'],
        ];
    }
}
