<?php

namespace App\Controller;

use App\Entity\Rate;
use App\Repository\CryptoRepository;
use App\Repository\CurrencyRepository;
use App\Repository\RateRepository;
use App\Resource\CryptoResource;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CryptoController extends AbstractController
{
    private $cryptoRepository;

    public function __construct(CryptoRepository $cryptoRepository)
    {
        $this->cryptoRepository = $cryptoRepository;
    }

    /**
     * @Route("/crypto", name="app_crypto")
     */
    public function index(): JsonResponse
    {

        $data = CryptoResource::prepare($this->cryptoRepository->findAll());

        return $this->json($data);
    }
}
