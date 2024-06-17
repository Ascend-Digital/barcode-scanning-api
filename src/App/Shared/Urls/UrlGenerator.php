<?php

namespace App\Shared\Urls;

use Domain\Barcodes\Models\ScannableAction;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class UrlGenerator
{
    public static function generateActionUrl(ScannableAction $action, ?array $parameters = null): ?string
    {
        try {
            return route($action->endpoint, $parameters, false);
        } catch (RouteNotFoundException $e) {
            Log::error($e->getMessage());

            return null;
        }
    }
}
