<?php

use App\Api\V1\Items\Requests\PlaceItemRequest;
use JMac\Testing\Traits\AdditionalAssertions;

uses(AdditionalAssertions::class);

it('has rules set up correctly', function () {
    $request = new PlaceItemRequest();

    $this->assertValidationRules([
        'quantity' => ['required', 'integer', 'min:1'],
    ], $request->rules());
});
