<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Exceptions\HelperNotSupported;
use Laravel\Nova\Notifications\NovaChannel;
use Laravel\Nova\Notifications\NovaNotification;
use Laravel\Nova\URL;

class PDFGenerated extends Notification
{
    use Queueable;

    public function __construct(private readonly string $filename)
    {
        //
    }

    public function via(object $notifiable): array
    {
        return [NovaChannel::class];
    }

    /**
     * @throws HelperNotSupported
     */
    public function toNova(object $notifiable): NovaNotification
    {
        return (new NovaNotification)
            ->message(__('Your PDF is ready to download'))
            ->action(__('Download'), URL::remote(Storage::disk('scannables')->url($this->filename)))
            ->openInNewTab()
            ->icon('download')
            ->type('info');
    }
}
