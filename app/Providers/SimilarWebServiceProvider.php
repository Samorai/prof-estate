<?php
namespace App\Providers;

use App\Exceptions\SimilarWebException;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application;
use Thunder\SimilarWebApi\Client;
use Thunder\SimilarWebApi\ClientFacade;

class SimilarWebServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('Thunder\SimilarWebApi\ClientFacade', function (Application $app) {
            $app_key = env('SIMILAR_WEB_APP_KEY', false);
            if (!$app_key) {
                throw new SimilarWebException('set similar web api key');
            }
            return new ClientFacade(new Client($app_key, 'JSON'));
        });
    }
}