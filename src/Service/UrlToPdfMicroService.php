<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class UrlToPdfMicroService
{
    public function __construct(
        private HttpClientInterface   $client,
        private ParameterBagInterface $params
    )
    {
    }

    public function convertUrlToPdf(string $url): string
    {
        $hostMicroService = $this->params->get('PDF_URL');

        $response = $this->client->request('POST', $hostMicroService . '/url/converter', [
            'body' => [
                'url' => $url
            ],
        ]);

        if ($response->getStatusCode() === 200) {
            return $response->getContent();
        } else {
            return new Response($response->getContent(), $response->getStatusCode());
        }
    }
}