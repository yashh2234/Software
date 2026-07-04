<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->ensureLegacyClientRegistrationsView();
    }

    private function ensureLegacyClientRegistrationsView(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        if (Schema::hasTable('client_registrations')) {
            return;
        }

        if (! Schema::hasTable('client_registration')) {
            return;
        }

        DB::statement('CREATE OR REPLACE VIEW `client_registrations` AS SELECT * FROM `client_registration`');
    }
}
