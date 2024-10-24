<?php
namespace App\Controller;
use Knp\Bundle\TimeBundle\DateTimeFormatter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ProductController extends AbstractController
{
    public $products = [];

    public function __construct()
    {
        $this->products = [
            [
                'id' => 0,
                'title' => 'Casque Audio',
                'price' => '500 ',
                'image' => 'headphone.jpg',
                'description' => 'Casque audio de haute qualité avec réduction de bruit et confort optimal.',
                'created_at' => new \DateTime('2023-09-11')
            ],
            [
                'id' => 1,
                'title' => 'Portable',
                'price' => '7200 ',
                'image' => 'phone.jpg',
                'description' => 'Smartphone dernier cri avec un écran AMOLED et une excellente performance.',
                'created_at' => new \DateTime('2023-10-12')
            ],
            [
                'id' => 2,
                'title' => 'Montre Intelligente',
                'price' => '600 ',
                'image' => 'watch.jpg',
                'description' => 'Montre intelligente avec suivi de l’activité et notifications en temps réel.',
                'created_at' => new \DateTime('2023-10-11')
            ],
            [
                'id' => 3,
                'title' => 'Caméra',
                'price' => '4550 ',
                'image' => 'camera.jpg',
                'description' => 'Caméra numérique avec une résolution élevée et plusieurs modes de prise de vue.',
                'created_at' => new \DateTime('2023-10-10')
            ],
        ];

    }
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
