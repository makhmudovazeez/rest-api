<?php

namespace App\Command;

use App\Entity\Rate;
use App\Repository\CryptoRepository;
use App\Repository\CurrencyRepository;
use App\Repository\RateRepository;
use App\Service\CryptoApiService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\HttpClient\ResponseInterface;

class GetRatesCommand extends Command
{
    protected static $defaultName = 'get:rates';
    protected static $defaultDescription = 'Add a short description for your command';
    private $cryptoRepository;
    private $currencyRepository;
    private $rateRepository;
    private $cryptoApiService;

    public function __construct(
        CryptoRepository $cryptoRepository,
        CurrencyRepository $currencyRepository,
        RateRepository $rateRepository,
        CryptoApiService $cryptoApiService,
        string $name = null
    )
    {
        parent::__construct($name);
        $this->currencyRepository = $currencyRepository;
        $this->cryptoRepository = $cryptoRepository;
        $this->rateRepository = $rateRepository;
        $this->cryptoApiService = $cryptoApiService;
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $date = new \DateTimeImmutable();
        foreach ($this->cryptoRepository->findAll() as $crypto){
            $response = $this->cryptoApiService->getRates("https://rest.coinapi.io/v1/exchangerate/{$crypto->getName()}");

            if (!$response instanceof ResponseInterface){
                $io->error($response);
                return Command::FAILURE;
            }

            $rates = $response->toArray()['rates'];

            foreach ($this->currencyRepository->findAll() as $currency){
                $rateIndex = array_search($currency->getName(), array_column($rates, 'asset_id_quote'));
                $result = $rates[$rateIndex];

                $entity = new Rate();
                $entity->setCrypto($crypto);
                $entity->setCurrency($currency);

                $entity->setValue($result['rate']);

                $entity->setCreatedAt($date->setTimestamp(strtotime($result['time'])));

                $this->rateRepository->add($entity, true);

            }
        }

        return Command::SUCCESS;
    }
}
