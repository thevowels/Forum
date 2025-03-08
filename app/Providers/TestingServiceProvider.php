<?php

namespace App\Providers;

use AssertionError;
use Illuminate\Support\ServiceProvider;
use Inertia\Testing\AssertableInertia;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Testing\TestResponse;

class TestingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if(! $this->app->runningUnitTests()){
            return;
        }

        AssertableInertia::macro('hasResource', function(string $key, JsonResource $resource){
            $props = $this->toArray()['props'];

            $compiledResource = $resource->response()->getData(true);

            expect($props)
                ->toHaveKey($key, message: "Key \"{$key}\" not passed as property to Inertia")
                ->and($props[$key])
                ->toEqual($compiledResource);

                return $this;
        });
        AssertableInertia::macro('hasPaginatedResource', function(string $key, ResourceCollection $resource){

            $props = $this->toArray()['props'];

            $compiledResource = $resource->response()->getData(true);

            expect($props)
                ->toHaveKey($key, message: "Key \"{$key}\" not passed as property to Inertia")
                ->and($props[$key])
                ->toHaveKeys(['data', 'links','meta'])
                ->data
                ->toEqual($compiledResource);

                return $this;
        });

        TestResponse::macro('assertHasResource', function (string $key, JsonResource $resource){
            return $this->assertInertia(fn (AssertableInertia $inertia) => $inertia->hasResource($key, $resource));
        });
        TestResponse::macro('assertHasPaginatedResource', function (string $key, ResourceCollection $resource){
            return $this->assertInertia(fn (AssertableInertia $inertia) => $inertia->hasPaginatedResource($key, $resource));
        });

        TestResponse::macro('assertComponent', function ( string $component){
            return $this->assertInertia(fn (AssertableInertia $inertia) => $inertia->component($component, true));
        });

    }
}
