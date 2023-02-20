<?php

return [
    'request_did_not_contain' => 'The request did not contain a header named `Mojopay-Signature`.',
    'signature_found_header_named' => 'The signature :name found in the header named `Mojopay-Signature is invalid. Make sure that the `services.mojopay.webhook_signing_secret` 
                                        config key is set to the value you found on the Mojopay dashboard. If you are caching your config try running `php artisan clear:cache` to resolve the problem.',
    'stripe_secret_not_set' => 'The Stripe Mojopay signing secret is not set. Make sure that the `mojopay.settings`  configured as required.',
    'invalid_two_checked_payload' => 'Invalid Mojopay Payload. Please check WebhookCall: :arg',
    'invalid_two_checked_invoice' => 'Invalid Mojopay Invoice Code. Please check WebhookCall: :arg',
    'invalid_two_checked_subscription' => 'Invalid Mojopay Subscription Reference. Please check WebhookCall: :arg',
    'invalid_two_checked_customer' => 'Invalid Mojopay Customer. Please check WebhookCall: :arg',


];