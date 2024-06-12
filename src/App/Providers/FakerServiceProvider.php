<?php

namespace App\Providers;

use Database\Factories\providers\ProcessProvider;
use Database\Factories\Providers\ProductProvider;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Support\ServiceProvider;

class FakerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Generator::class, function () {
            $faker = Factory::create();
            $faker->addProvider(new ProcessProvider($faker));
            $faker->addProvider(new ProductProvider($faker));

            return $faker;
        });
    }
}
