<?php
namespace App\Controller;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductApiController extends AbstractController
{
    protected $products;
    public function __construct()
    {
        $this->products = [
            [
                'id' => 0,
                'title' => 'Casque Audio',
                'price' => '500',
                'image' => 'headphone.jpg',
                'description' => 'Casque audio de haute qualité avec réduction de bruit et confort optimal.',
            ],
            [
                'id' => 1,
                'title' => 'Portable',
                'price' => '7200',
                'image' => 'phone.jpg',
                'description' => 'Smartphone dernier cri avec un écran AMOLED et une excellente performance.',
            ],
            [
                'id' => 2,
                'title' => 'Montre Intelligente',
                'price' => '600',
                'image' => 'watch.jpg',
                'description' => 'Montre intelligente avec suivi de l’activité et notifications en temps réel.',
            ],
            [
                'id' => 3,
                'title' => 'Caméra',
                'price' => '4550',
                'image' => 'camera.jpg',
                'description' => 'Caméra numérique avec une résolution élevée et plusieurs modes de prise de vue.',
            ],
        ];
    }

    #[Route(path: '/api/products', methods: ['GET'])]
    public function products(): Response
    {
        return $this->json($this->products);
    }

    #[Route(path: '/api/product/{id<\d+>}', methods: ['GET'])]
    public function product($id, LoggerInterface $logger): Response
    {
        $logger->info('Api call User id=#{id}', ['id' => $id]);
        return $this->json($this->products[$id]);
    }

    #[Route(path: '/api/product/{id<\d+>}', methods: ['POST'], name: 'cart_add')]
    public function addToCart($id, LoggerInterface $logger): Response
    {
        $logger->info(
            'Product id=#{id} Added successfully',
            ['id' => $id]
        );
        return $this->json($this->products[$id]);
    }
}