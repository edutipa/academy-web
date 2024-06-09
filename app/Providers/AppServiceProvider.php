<?php

namespace App\Providers;

use App\Models\Language;
use App\Models\Setting;
use App\Models\Timezone;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Schema::defaultStringLength(191);

        $this->app->singleton('settings', function () {
            return Cache::rememberForever('settings', function () {
                return Schema::hasTable('settings') ? Setting::all() : collect();
            });
        });
        $this->app->singleton('languages', function () {
            return Cache::rememberForever('languages', function () {
                return Schema::hasTable('languages') ? Language::where('status', 1)->get() : collect();
            });
        });
        $this->app->singleton('permission_list', function () {
            return Auth()->user()->permissions;
        });
    }
}
