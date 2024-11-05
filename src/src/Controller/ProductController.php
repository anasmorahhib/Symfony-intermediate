<?php
namespace App\Controller;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ProductController extends AbstractController
{
    #[Route(path: '/product/new')]
    public function new(EntityManagerInterface $entityManager): Response
    {
        $product = new Product();
        $product->setTitle('Gadget Super Cool');
        $product->setDescription('Un gadget incroyable, indispensable dans votre quotidien !');
        $cities = ['Casablanca', 'Rabat', 'El Jadida'];
        $product->setCity($cities[array_rand($cities)]);
        $product->setPrice(rand(10, 100));
        $product->setQuantity(rand(1, 50));

        $entityManager->persist($product);
        $entityManager->flush();

        return new Response(sprintf(
            'Le produit %d", disponible à %s.',
            $product->getId(),
            $product->getCity()
        ));
    }

    #[Route(path: '/product/list/{city?}', name: 'products')]
    public function products(ProductRepository $productRepository, string $city = null)
    {
        $products = $productRepository->findAllOrderedByPrice($city);
        return $this->render(
            'product/list.html.twig',
            ['products' => $products]
        ); // render return a Response
    }

    #[Route('/product/{id<\d+>}', name: 'product_show')]
    public function show(int $id, ProductRepository $productRepository)
    {
        $product = $productRepository->find($id);

        return $this->render(
            'product/single.html.twig',
            ['product' => $product]
        );
    }


}
