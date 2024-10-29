<?php

namespace App\Service;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bridge\Twig\Command\DebugCommand;


class ProductRepository
{
    private HttpClientInterface $httpClient;
    private CacheInterface $cache;
    private bool $isDebug;
    private DebugCommand $twigDebugCommand;

    public function __construct(DebugCommand $twigDebugCommand, HttpClientInterface $githubContentClient, CacheInterface $cache, bool $isDebug)
    {
        $this->httpClient = $githubContentClient;
        $this->cache = $cache;
        $this->isDebug = $isDebug;
        $this->twigDebugCommand = $twigDebugCommand;
    }

    public function findAll()
    {
        return $this->cache->get(
            'products_data',
            function ($productCache) {
                $productCache->expiresAfter($this->isDebug ? 60 : 1080);
                $response = $this->httpClient->request(
                    'GET',
                    '/anasmorahhib/data/refs/heads/main/products.json'
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
