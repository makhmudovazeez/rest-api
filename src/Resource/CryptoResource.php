<?php

namespace App\Resource;

use App\Entity\Crypto;

class CryptoResource
{
    /**
     * @param Crypto[] $cryptos
     * @return array
     */
    public static function prepare(array $cryptos): array
    {
        $data = [];

        foreach ($cryptos as $crypto){
            $cry = $crypto->getName();
            foreach ($crypto->getRates() as $index => $rate){
                $curr = $rate->getCurrency()->getName();

                $data[$cry][$curr][] = [
                    'time' => $rate->getCreatedAt()->getTimestamp(),
                    'rate' => $rate->getValue(),
                ];

            }
        }

        return $data;
    }
}