<?php
namespace App\Controller;
use App\Service\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Twig\Environment;

class ProductController extends AbstractController
{

    // Routes config file
    public function products(ProductRepository $productRepository)
    {
        $products = $productRepository->findAll();
        return $this->render(
            'product/list.html.twig',
            ['products' => $products]
        ); // render return a Response
    }

    public function product(int $id, ProductRepository $productRepository, Environment $twig)
    {
        $product = $productRepository->findById($id);

        $html = $twig->render(
            'product/single.html.twig',
            ['product' => $product]
        );

        return new Response($html);
    }

    public function new()
    {
        return new Response("New Product Page");
    }

}
