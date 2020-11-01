<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\TransactionDTO;
use App\Enum\CountryCodeEnum;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Config\Definition\Exception\Exception;

class CommissionService
{
    private Parser $parser;
    private HttpClientInterface $httpClient;

    public function __construct(Parser $parser, HttpClientInterface $httpClient)
    {
        $this->parser = $parser;
        $this->httpClient = $httpClient;
    }

    public function getCommissions(string $fileName): array
    {
        $transactionsDTOCollection = $this->parser->parse($fileName);
        $amounts = [];
        /** @var TransactionDTO $transactionDTO */
        foreach ($transactionsDTOCollection->all() as $transactionDTO) {
            $countryCode = $this->getCountryCodeByBin($transactionDTO->getBin());
            $isEu = $this->isEu($countryCode);
            $rate = $this->getRate($transactionDTO->getCurrency());
            if ($transactionDTO->getCurrency() == 'EUR' or $rate == 0) {
                $amount = $transactionDTO->getAmount();
            } elseif ($transactionDTO->getCurrency() != 'EUR' or $rate > 0) {
                $amount = $transactionDTO->getAmount() / $rate;
            }
            $commission = $isEu === true ? 0.01 : 0.02;
            $amount = $amount * $commission;
            $amounts[] = bcadd((string) $amount, '0', 2);
        }

        return $amounts;
    }


    private function isEu(string $currencyCode): bool
    {
        return in_array($currencyCode, CountryCodeEnum::values());
    }

    private function getCountryCodeByBin(string $bin): string
    {
        $uri = sprintf('https://lookup.binlist.net/%s', $bin);
        try {
            $binResponse = $this->httpClient->request('GET', $uri);
        } catch (GuzzleException $exception) {
            throw new Exception(sprintf('Transaction with bin = "%s" not found', $bin));
        }

        $binResult = json_decode($binResponse->getBody()->getContents(), true);

        return $binResult['country']['alpha2'];
    }

    private function getRate(string $currency): ?float
    {
        $ratesResponse = $this->httpClient->request('GET', 'https://api.exchangeratesapi.io/latest');
        $ratesResponse = json_decode($ratesResponse->getBody()->getContents(), true);

        $rate = null;
        if (isset($ratesResponse['rates'][$currency])) {
            $rate = $ratesResponse['rates'][$currency];
        }

        return $rate;
    }
}
