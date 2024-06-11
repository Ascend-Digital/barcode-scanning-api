<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceResponse;
use Illuminate\Testing\TestResponse;
use Request;

abstract class TestCase extends BaseTestCase
{
    public function assertJsonResponseContent(JsonResource $resource, TestResponse $response, ?Request $request = null): void
    {
        $request = $request ?? request();

        $this->assertEquals(
            (new ResourceResponse($resource))->toResponse($request)->content(),
            $response->content()
        );
    }
}
