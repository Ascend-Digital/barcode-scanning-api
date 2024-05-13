<?php

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('api/{version}/docs', function (string $version) {
    return view('docs', [
        'url' => route('docs.definition', ['version' => $version]),
    ]);
});
