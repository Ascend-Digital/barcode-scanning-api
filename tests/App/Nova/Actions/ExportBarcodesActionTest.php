<?php

namespace Tests\App\Nova\Actions;

use App\Notifications\PDFGenerated;
use App\Nova\Actions\ExportBarcodes;
use Domain\Items\Models\Item;
use Domain\Users\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use JoshGaber\NovaUnit\Actions\NovaActionTest;

uses(NovaActionTest::class);

it('saves a pdf and sends a notification to the user', function () {
    Storage::fake('scannables');
    Notification::fake();

    $user = User::factory()->create();
    $item = Item::factory()->create();
    $this->actingAs($user);

    $action = $this->novaAction(ExportBarcodes::class);
    $actionFields = ['type' => 'QRCODE'];

    $action->handle($actionFields, $item);

    $files = Storage::disk('scannables')->files();
    $this->assertCount(1, $files);

    Notification::assertCount(1);
    Notification::assertSentTo($user, PDFGenerated::class);
});
