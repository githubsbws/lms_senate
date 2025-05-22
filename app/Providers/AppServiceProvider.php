<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Psr\Http\Client\ClientInterface;
use GuzzleHttp\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Permission;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        //
        // $this->app->bind(ClientInterface::class, Client::class);
        $this->app->bind(ClientInterface::class, function ($app) {
            return ClientBuilder::create()
                ->setHosts([config('scout.elasticsearch.host')])
                ->setBasicAuthentication(config('scout.elasticsearch.user'), config('scout.elasticsearch.pass'))
                ->build();
        });

        $this->app->bind(\Elastic\Elasticsearch\Client::class, function($app) {
            $host = config('scout.elasticsearch.host');
            if (is_null($host)) {
                throw new \Exception('Elasticsearch host is not set.');
            }
            
            return ClientBuilder::create()
                ->setHosts([$host])  // Ensure $host is a valid string
                ->setBasicAuthentication(config('scout.elasticsearch.user'), config('scout.elasticsearch.pass'))
                ->build();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Paginator::useBootstrapFive();
        // dd(env('ELASTICSEARCH_PASSWORD'));
        
        // $client = ClientBuilder::create()
        //     ->setHosts([config('scout.elasticsearch.host')])  // แก้ไขเป็น array
        //     ->setBasicAuthentication(config('scout.elasticsearch.user'), config('scout.elasticsearch.pass'))
        //     ->build();
        // $client = ClientBuilder::create()
        // ->setHosts([env('scout.elasticsearch.host')])
        // ->setBasicAuthentication(env('scout.elasticsearch.user'), env('scout.elasticsearch.pass'))
        // ->build();
        
        // // // ทดสอบการเชื่อมต่อ
        // $response = $client->info();
        // dd($response->asArray());

        View::composer('*', function ($view) {
            if (Auth::check()) {
                $typeUserId = Auth::user()->type_user_id;
                $permissions = Permission::where('type_user_id', $typeUserId)
                    ->where('can_access', true)
                    ->pluck('key')
                    ->toArray();

                $view->with('currentPermissions', $permissions);
            } else {
                $view->with('currentPermissions', []);
            }
        });
    }
}
