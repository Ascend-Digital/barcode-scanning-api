<?php

use App\Providers\FakerServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\HorizonServiceProvider::class,
    App\Providers\NovaServiceProvider::class,
    FakerServiceProvider::class,
];
