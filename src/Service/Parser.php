<?php

declare(strict_types=1);

namespace App\Service;

use App\Collection\TransactionDTOCollection;
use App\DTO\TransactionDTO;

class Parser
{
    public function parse(string $fileName): TransactionDTOCollection
    {
        $handle = @fopen($fileName, "r");
        $transactions = [];
        if ($handle) {
            while (($buffer = fgets($handle, 4096)) !== false) {
                $data = json_decode($buffer);
                $transactions[] = new TransactionDTO($data->bin, $data->amount, $data->currency);
            }
            if (!feof($handle)) {
                throw new \Exception('Unexpected error');
            }
            fclose($handle);
        }

        return new TransactionDTOCollection($transactions);
    }
}
