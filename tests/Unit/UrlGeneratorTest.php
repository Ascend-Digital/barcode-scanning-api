<?php

use App\Shared\Urls\UrlGenerator;
use Domain\Barcodes\Models\ScannableAction;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('generates urls correctly', function () {
    $action = ScannableAction::factory([
        'owner_type' => 'workstation',
        'endpoint' => 'api.v1.barcodes.scan',
        'key' => 'key',
    ])->create();
    $params = [1];

    $value = UrlGenerator::generateActionUrl($action, $params);
    $this->assertSame(route('api.v1.barcodes.scan', $params, false), $value);
});
