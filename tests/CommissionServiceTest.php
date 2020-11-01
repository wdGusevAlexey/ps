<?php

declare(strict_types=1);

namespace App\Tests\Util;

use App\Collection\TransactionDTOCollection;
use App\DTO\TransactionDTO;
use App\Service\CommissionService;
use App\Service\HttpClientInterface;
use App\Service\Parser;
use GuzzleHttp\Psr7\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommissionServiceTest extends WebTestCase
{
    public function testGetCommissions()
    {
        $parser = $this->createMock(Parser::class);
        $httpClient = $this->createMock(HttpClientInterface::class);

        $transaction1 = new TransactionDTO('45717360', '100.00', 'EUR');
        $transaction2 = new TransactionDTO('516793', '50.00', 'USD');
        $transactionDTOCollection = new TransactionDTOCollection([$transaction1, $transaction2]);

        $parser->expects(self::once())->method('parse')->willReturn($transactionDTOCollection);
        $httpClient->expects(self::at(0))->method('request')->willReturn(new Response(200, [], '{"number":{"length":16,"luhn":true},"scheme":"visa","type":"debit","brand":"Visa/Dankort","prepaid":false,"country":{"numeric":"208","alpha2":"DK","name":"Denmark","emoji":"🇩🇰","currency":"DKK","latitude":56,"longitude":10},"bank":{"name":"Jyske Bank","url":"www.jyskebank.dk","phone":"+4589893300","city":"Hjørring"}}'));
        $httpClient->expects(self::at(1))->method('request')->willReturn(new Response(200, [], '{"number":{},"scheme":"mastercard","type":"debit","brand":"Debit","country":{"numeric":"440","alpha2":"LT","name":"Lithuania","emoji":"🇱🇹","currency":"EUR","latitude":56,"longitude":24},"bank":{}}'));
        $httpClient->expects(self::at(2))->method('request')->willReturn(new Response(200, [], '{"number":{"length":16,"luhn":true},"scheme":"visa","type":"debit","brand":"Visa/Dankort","prepaid":false,"country":{"numeric":"208","alpha2":"DK","name":"Denmark","emoji":"🇩🇰","currency":"DKK","latitude":56,"longitude":10},"bank":{"name":"Jyske Bank","url":"www.jyskebank.dk","phone":"+4589893300","city":"Hjørring"}}'));
        $httpClient->expects(self::at(3))->method('request')->willReturn(new Response(200, [], '{"number":{"length":16,"luhn":true},"scheme":"visa","type":"debit","brand":"Visa/Dankort","prepaid":false,"country":{"numeric":"208","alpha2":"DK","name":"Denmark","emoji":"🇩🇰","currency":"DKK","latitude":56,"longitude":10},"bank":{"name":"Jyske Bank","url":"www.jyskebank.dk","phone":"+4589893300","city":"Hjørring"}}'));

        $service = new CommissionService($parser, $httpClient);
        $result = $service->getCommissions('file.txt');

        $this->assertEquals(['1.00', '0.50'], $result);
    }
}