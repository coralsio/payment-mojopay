<?php

namespace Corals\Modules\Payment\Mojopay\Providers;

use Corals\Foundation\Providers\BaseUpdateModuleServiceProvider;

class UpdateModuleServiceProvider extends BaseUpdateModuleServiceProvider
{
    protected $module_code = 'corals-payment-mojopay';
    protected $batches_path = __DIR__ . '/../update-batches/*.php';
}
