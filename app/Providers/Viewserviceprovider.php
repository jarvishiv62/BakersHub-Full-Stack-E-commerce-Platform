<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\View\Composers\HeaderComposer;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

public function boot()
{
    View::composer('partials.header', HeaderComposer::class);
}
}