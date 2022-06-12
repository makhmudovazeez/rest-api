<?php

namespace App\DataFixtures;

use App\Repository\CryptoRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Crypto;

class CryptoFixtures extends Fixture
{
    private $cryptoRepository;
    const CRYPTOS = ['BTC', 'ETH'];

    public function __construct(CryptoRepository $cryptoRepository)
    {
        $this->cryptoRepository = $cryptoRepository;
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this::CRYPTOS as $crypto) {
            if ($this->cryptoRepository->findOneBy(['name' => strtoupper($crypto)])){
                continue;
            }
            $entity = new Crypto();
            $entity->setName($crypto);
            $entity->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($entity);
        }

        $manager->flush();
    }
}
