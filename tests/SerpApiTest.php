<?php

namespace Endless\SerpApi;

use Endless\SerpApi\Exception\SerpApiException;

class SerpApiTest extends EngineTest
{
    public function testIfExceptionThrownWithInvalidResourceName()
    {
        $this->expectException(SerpApiException::class);

        self::$serpApi->someFakeResource;
    }

    public function testIfExceptionNotThrownWithValidResourceName()
    {
        $this->expectNotToPerformAssertions();

        self::$serpApi->Account;
    }
}