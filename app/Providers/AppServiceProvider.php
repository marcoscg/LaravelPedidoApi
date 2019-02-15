<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Doctrine\Common\Annotations\AnnotationReader;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        AnnotationReader::addGlobalIgnoredName('OA');
        AnnotationReader::addGlobalIgnoredName('OA\Schema');
        AnnotationReader::addGlobalIgnoredName('OA\Property');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
