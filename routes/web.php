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

Route::get('api/docs/{version}/definition', function (string $version) {
    $filesystem = new Filesystem();

    $path = base_path('/documentation/'.$version.'.json');
    $contents = $filesystem->get($path);

    return response($contents)->header('Content-Type', 'application/json');
})->name('docs.definition');
