<?php
namespace App\Controller;
use App\Entity\Cart;
use App\Entity\Product;
use App\Repository\CartRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ProductController extends AbstractController
{
    #[Route(path: '/product/new')]
    public function new(EntityManagerInterface $entityManager): Response
    {
        $product = new Product();
        $titles = [
            'Gadget Super Cool',
            'Smart Widget',
            'Amazing Gizmo',
            'Techie Delight',
            'Innovative Device',
            'Next-Gen Gadget',
            'Ultimate Tool',
            'FutureTech Gadget'
        ];
        $product->setTitle($titles[array_rand($titles)]);
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
    public function products(ProductRepository $productRepository, CartRepository $cartRepository, string $city = null)
    {
        $products = $productRepository->findAllOrderedByPrice($city);
        $totalQuantity = $cartRepository->getTotalQuantity();
        return $this->render(
            'product/list.html.twig',
            [
                'products' => $products,
                'totalQuantity' => $totalQuantity,
            ]
        ); // render return a Response
    }

    #[Route('/product/{slug}', name: 'product_show')]
    public function show(Product $product)
    {
        return $this->render(
            'product/single.html.twig',
            ['product' => $product]
        );
    }


    #[Route('/product/{id<\d+>}/add-to-cart', name: 'add_to_cart', methods: ['POST'])]
    public function addToCart(Product $product, Request $request, EntityManagerInterface $entityManager): Response
    {
        $quantity = $request->request->get('quantity', 1);
        if ($quantity <= $product->getQuantity()) {
            // Create a new CartItem
            $cart = $product->getCart() ?? new Cart();
            $cart->setProduct($product);
            $cart->setQuantity($quantity);
            $entityManager->persist($cart);
            $entityManager->flush();
            $this->addFlash('success', 'Panier mis à jour avec succès.');
            return $this->redirectToRoute('products');
        }

        $this->addFlash('error', 'Stock insuffisant.');
        return $this->redirectToRoute('products');
    }

    #[Route('/cart', name: 'show_cart')]
    public function showCart(CartRepository $cartRepository)
    {
        $cart = $cartRepository->findAll();

        return $this->render(
            'cart/index.html.twig',
            ['cart' => $cart]
        );
    }
}
