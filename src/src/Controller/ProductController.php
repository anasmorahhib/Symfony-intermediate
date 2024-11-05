<?php
namespace App\Controller;
use App\Entity\Product;
use App\Service\ProductRepository as ProductService;
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
        $product->setCity('Casablanca');
        $product->setPrice(rand(10, 100));
        $product->setQuantity(rand(1, 50));

        $entityManager->persist($product);
        $entityManager->flush();

        return new Response(sprintf(
            'Le produit %d, "%s", est disponible à %d € avec %d en stock.',
            $product->getId(),
            $product->getTitle(),
            $product->getPrice(),
            $product->getQuantity()
        ));
    }

    #[Route(path: '/product/list', name: 'products')]
    public function products(ProductRepository $productRepository)
    {
        $products = $productRepository->findBy([], orderBy: ['price' => 'DESC']);
        return $this->render(
            'product/list.html.twig',
            ['products' => $products]
        ); // render return a Response
    }

    #[Route('/product/{id<\d+>}', name: 'product')]
    public function product(int $id, ProductService $ProductService, Environment $twig)
    {
        $product = $ProductService->findById($id);

        $html = $twig->render(
            'product/single.html.twig',
            ['product' => $product]
        );

        return new Response($html);
    }


}
