<?php

namespace App\Service;

use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ProductRepository
{
    private HttpClientInterface $httpClient;
    private CacheInterface $cache;

    public function __construct(HttpClientInterface $httpClient, CacheInterface $cache)
    {
        $this->httpClient = $httpClient;
        $this->cache = $cache;
    }

    public function findAll()
    {
        return $this->cache->get(
            'products_data',
            function ($productCache) {
                $productCache->expiresAfter(60);
                $response = $this->httpClient->request(
                    'GET',
                    'https://raw.githubusercontent.com/anasmorahhib/formation_symfony6/refs/heads/main/0.data/products.json'
                );
                return $response->toArray();
            }
        );
    }

    public function findById(int $id)
    {
        $products = $this->findAll();
        return $products[$id];
    }
}
