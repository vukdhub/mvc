<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ControllerTwig extends AbstractController
{
    #[Route("/lucky/number/twig", name: "lucky_number")]
    public function number(): Response
    {
        $number = random_int(0, 100);

        $imageUrls = [
            './img/image1.png',
            './img/image2.jpg',

        ];
        $randomImageUrl = $imageUrls[array_rand($imageUrls)];

        $data = [
            'number' => $number,
            'randomImageUrl' => $randomImageUrl
        ];

        return $this->render('lucky_number.html.twig', $data);
    }

    #[Route("/", name: "me")]
    public function me(): Response
    {
        return $this->render('me.html.twig');
    }

    #[Route("/about", name: "about")]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

    #[Route("/report", name: "report")]
    public function report(Request $request): Response
    {
        // Get the kursmoment from the URL fragment
        $kursmoment = $request->query->get('kmom');

        if ($kursmoment === null) {
            $kursmoment = 'kmom01'; 
        }

        $redovisningstext = $this->getRedovisningstext($kursmoment);

        return $this->render('report.html.twig', [
            'redovisningstext' => $redovisningstext,
            'kursmoment' => $kursmoment
        ]);
    }

    private function getRedovisningstext(string $kmom): string
    {

        $redovisningstextArray = [
            'kmom01' => 'Redovisningstext for Kmom01...',
            'kmom02' => 'Redovisningstext for Kmom02...',
        ];

        return $redovisningstextArray[$kmom] ?? 'Redovisningstext not found';
    }

}