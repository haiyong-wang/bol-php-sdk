<?php
declare(strict_types=1);

namespace Exewen\Bol\Services;

use Exewen\Config\Contract\ConfigInterface;
use Exewen\Http\Contract\HttpClientInterface;

class OffersService
{
    private $httpClient;
    private $driver;
    private $offersListUrl = '/retailer/offers';
    private $offersDetailUrl = '/retailer/offers/{offer-id}';

    public function __construct(HttpClientInterface $httpClient, ConfigInterface $config)
    {
        $this->httpClient = $httpClient;
        $this->driver     = $config->get('bol.channel_api');
    }

    public function getOffers(array $params, array $header): string
    {
        $response = $this->httpClient->get($this->driver, $this->offersListUrl, $params, $header);
        return $response->getBody()->getContents();
    }

    public function createOffer(array $data, array $header): string
    {
        $response = $this->httpClient->post($this->driver, $this->offersListUrl, $data, $header);
        return $response->getBody()->getContents();
    }

    public function updateOffer(string $offerId, array $data, array $header): string
    {
        $url    = str_replace('{offer-id}', $offerId, $this->offersDetailUrl);
        $response = $this->httpClient->put($this->driver, $url, $data, $header);
        return $response->getBody()->getContents();
    }

}