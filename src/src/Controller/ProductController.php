<?php
namespace App\Controller;
use Knp\Bundle\TimeBundle\DateTimeFormatter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Twig\Environment;

class ProductController extends AbstractController
{

    // Routes config file
    public function products(HttpClientInterface $httpClient)
    {
        $response = $httpClient->request('GET', 'https://raw.githubusercontent.com/anasmorahhib/formation_symfony6/refs/heads/main/0.data/products.json');
        $products = $response->toArray();

        return $this->render(
            'product/list.html.twig',
            ['products' => $products]
        ); // render return a Response
    }

    public function product($id, Environment $twig, HttpClientInterface $httpClient)
    {
        $response = $httpClient->request('GET', 'https://raw.githubusercontent.com/anasmorahhib/formation_symfony6/refs/heads/main/0.data/products.json');
        $products = $response->toArray();
        $html = $twig->render(
            'product/single.html.twig',
            ['product' => $products[$id]]
        );

        return new Response($html);
    }

    public function new()
    {
        return new Response("New Product Page");
    }

}
