<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class CryptoApiService
{
    private $client;
    private $params;

    const HTTP_ERROR_MESSAGE = [
        400 => 'Bad Request -- There is something wrong with your request',
        401 => 'Unauthorized -- Your API key is wrong',
        403 => 'Forbidden -- Your API key doesnt\'t have enough privileges to access this resource',
        429 => 'Too many requests -- You have exceeded your API key rate limits',
        550 => 'No data -- You requested specific single item that we don\'t have at this moment.',
    ];

    public function __construct(HttpClientInterface $client, ParameterBagInterface $params)
    {
        $this->client = $client;
        $this->params = $params;
    }

    public function getRates(string $url)
    {
        $response = $this->client->request(
            Request::METHOD_GET,
            $url,
            [
                'query' => [
                    'apikey' => $this->params->get('apikey')
                ]
            ]
        );

        if ($response->getStatusCode() != Response::HTTP_OK)
            return self::HTTP_ERROR_MESSAGE[$response->getStatusCode()];

        return $response;
    }
}