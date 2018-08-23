<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191); //767/4
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        event('clear.node',function(){
            Cache::forget('user_node_tree');

            dump(111);
        });
    }
}
