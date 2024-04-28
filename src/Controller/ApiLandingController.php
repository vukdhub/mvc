<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiLandingController extends AbstractController
{
    #[Route("api/landing", name: "api_landing")]
    public function api(): Response
    {

        $apiRoutes = [
            ['name' => 'Route 1', 'url' => $this->generateUrl('api_quote')],
            ['name' => 'Route 2', 'url' => '/api/route2'],

        ];

        return $this->render('api/landing.html.twig', [
            'apiRoutes' => $apiRoutes,
        ]);
    }

    #[Route("api/quote", name: "api_quote")]
    public function getQuote(): Response
    {

        $quotes = [
            "It's a Long Way to the Top (If You Wanna Rock n Roll)",
            "For Those About to Rock We Salute You",
            "Let There Be Rock"
        ];

        $randomQuote = $quotes[array_rand($quotes)];

        // Skapa JSON-svar
        $response = [
            'quote' => $randomQuote,
            'date' => date('Y-m-d'),
            'timestamp' => time()
        ];

        // Returnera JSON-svar
        return $this->json($response);
    }
}
