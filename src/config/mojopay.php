<?php

return [
    'name' => 'Mojopay',
    'key' => 'payment_mojopay',
    'support_subscription' => false,
    'support_ecommerce' => true,
    'manage_remote_plan' => false,
    'create_remote_customer' => false,
    'capture_payment_method' => true,
    'require_default_payment_set' => true,
    'supports_swap' => false,
    'can_update_payment' => true,
    'supports_swap_in_grace_period' => false,
    'require_invoice_creation' => false,
    'require_plan_activation' => false,
    'require_payment_token' => false,
    'support_online_refund' => true,

    'settings' => [
        'live_api_key' => [
            'label' => 'Mojopay::labels.settings.live_api_key',
            'type' => 'text',
            'required' => false,
        ],
        'sandbox_mode' => [
            'label' => 'Mojopay::labels.settings.sandbox_mode',
            'type' => 'boolean'
        ],
        'sandbox_api_key' => [
            'label' => 'Mojopay::labels.settings.sandbox_api_key',
            'type' => 'text',
            'required' => false,
        ]
    ],
    'events' => [
    ],
    'webhook_handler' => \Corals\Modules\Payment\Mojopay\Gateway::class,
];
