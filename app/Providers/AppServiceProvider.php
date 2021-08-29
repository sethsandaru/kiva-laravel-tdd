<?php

namespace App\Providers;

use App\Domains\ImageManageContract;
use App\Services\ImageServices\ImgurImageService;
use App\Services\ImageServices\SelfHostedImageService;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // registering the contract
        $this->app->bind(ImageManageContract::class, function ($app, $parameters) {
            if (isset($parameters['service'])) {
                $imageServices = new Collection([
                    SelfHostedImageService::NAME => SelfHostedImageService::class,
                    ImgurImageService::NAME => ImgurImageService::class,
                ]);

                return app($imageServices[$parameters['service']]);
            }
        });
    }
}
