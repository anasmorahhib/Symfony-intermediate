<?php
namespace App\Controller;
use Knp\Bundle\TimeBundle\DateTimeFormatter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ProductController extends AbstractController
{
    
    // Routes config file
    public function products(DateTimeFormatter $dateTimeFormatter)
    {
        return $this->render(
            'product/list.html.twig',
            ['products' => $this->products]
        ); // render return a Response
    }

    public function product($id, Environment $twig)
    {
        $html = $twig->render(
            'product/single.html.twig',
            ['product' => $this->products[$id]]
        );

        return new Response($html);
    }

    public function new()
    {
        return new Response("New Product Page");
    }

}
