<?php

use App\Api\V1\Items\Requests\PickItemRequest;
use JMac\Testing\Traits\AdditionalAssertions;

uses(AdditionalAssertions::class);

it('has rules set up correctly', function () {
    $request = new PickItemRequest();

    $this->assertValidationRules([
        'quantity' => ['required', 'integer', 'min:1'],
    ], $request->rules());
});
