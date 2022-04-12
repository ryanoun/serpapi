<?php

namespace Endless\SerpApi;

use Endless\SerpApi\Account;

class AccountTest extends EngineTest
{    
    public function testIfCanCreateAccountResource()
    {
        self::$serpApi->Account;

        $this->assertTrue(true);
    }

    public function testIfReturnedAccountInfo()
    {
        $account = $this->getMockBuilder(Account::class)
            ->setMethods(['get'])
            ->getMock();

        $account->method('get')
            ->willReturn(json_decode(file_get_contents(__DIR__ . '/MockResponses/AccountResponse.json'), true));

        $accountInfo = $account->get();

        $this->assertSame('some@email.com', $accountInfo['account_email']);
    }
}