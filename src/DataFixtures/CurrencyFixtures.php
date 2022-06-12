<?php

namespace App\DataFixtures;

use App\Entity\Currency;
use App\Repository\CurrencyRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CurrencyFixtures extends Fixture
{
    private $currencyRepository;
    const CURRENCIES = ['USD', 'EUR', 'UAH'];

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this::CURRENCIES as $currency){
            if ($this->currencyRepository->findOneBy(['name' => strtoupper($currency)])){
                continue;
            }
            $entity = new Currency();
            $entity->setName($currency);
            $entity->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($entity);
        }

        $manager->flush();
    }
}
