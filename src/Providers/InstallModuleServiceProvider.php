<?php

namespace Corals\Modules\Payment\Mojopay\Providers;

use Carbon\Carbon;
use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected function providerBooted()
    {
        $supported_gateways = \Payments::getAvailableGateways();

        $supported_gateways['Mojopay'] = 'Mojopay';

        \Payments::setAvailableGateways($supported_gateways);

        \DB::table('settings')->insert([
            [
                'code' => 'payment_mojopay_live_api_key',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_mojopay_api_key',
                'value' => 'api_xxxxxxxxxxxxxxxxxxxxxx',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_mojopay_sandbox_mode',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_mojopay_sandbox_mode',
                'value' => 'true',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_mojopay_sandbox_api_key',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_mojopay_sandbox_api_key',
                'value' => 'hfwwMUQiHsYX6kf828M2t8vF7AfocrAYlnbKUMaJseol8HFt',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]

        ]);
    }
}
