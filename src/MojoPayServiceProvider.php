<?php

namespace Corals\Modules\Payment\Mojopay;

use Illuminate\Support\ServiceProvider;
use Corals\Settings\Facades\Modules;

class MojoPayServiceProvider extends ServiceProvider
{
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerModulesPackages();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }

    public function registerModulesPackages()
    {
        Modules::addModulesPackages('corals/payment-mojopay');
    }
}
