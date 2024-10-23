<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController
{
    // Simple Route
    #[Route('/', name: 'homePage')]
    public function homePage(): Response
    {
        return new Response('Hi, Im a home page.');
    }

    // WildCard Route
    #[Route('/user/{name}')]
    public function profile(string $name = null): Response
    {
        if ($name) {
            return new Response(content: "Hello " . $name);
        }
        return new Response("Hello World");
    }

}
