<?php

// src/Controller/DeckController.php

namespace App\Controller;

use App\DeckOfCards\DeckOfCards;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ApiDeckController extends AbstractController
{
    #[Route("/api/game/card/sorted", name: "sorted_cards_api", methods: ['GET'])]
    public function displaySortedCardsApi(SessionInterface $session): JsonResponse
    {
        {
            $session->clear();
            $deck = new DeckOfCards();
            $session->set('deck', $deck);

            return $this->json($deck->getCards());
        }
    }

    #[Route("/api/game/card/shuffle", name: "shuffle_cards_api", methods: ['POST'])]
    public function displayShuffledCardsApi(SessionInterface $session): JsonResponse
    {
        $deck = $session->get('deck', new DeckOfCards());
        $deck->shuffle();
        $session->set('deck', $deck);

        return $this->json($deck->getCards());

    }

    #[Route("/api/deck/draw", name: "api_deck_draw", methods: ['POST'])]
    public function drawCard(SessionInterface $session): JsonResponse
    {
        $deck = $session->get('deck_of_cards', new DeckOfCards());

        $drawnCard = $deck->drawRandomCard();

        $drawnCards = $session->get('drawn_cards', []);
        $drawnCards[] = $drawnCard;
        $session->set('drawn_cards', $drawnCards);

        $remainingCards = count($deck->getCards());
        $session->set('remaining_cards', $remainingCards);

        $session->set('deck_of_cards', $deck);

        return $this->json([
            'drawn_card' => $drawnCard,
            'remaining_cards' => $remainingCards
        ]);
    }

    #[Route("/api/deck/draw/{number}", name: "api_multiple", methods: ['POST'])]
    public function drawCards(int $number, SessionInterface $session): JsonResponse
    {
        $deck = $session->get('deck_of_cards', new DeckOfCards());

        $drawnCards = $deck->drawMultipleCards($number);

        $drawnCardsSession = $session->get('drawn_cards', []);
        $drawnCardsSession = array_merge($drawnCardsSession, $drawnCards);
        $session->set('drawn_cards', $drawnCardsSession);

        $remainingCards = count($deck->getCards());
        $session->set('remaining_cards', $remainingCards);

        $session->set('deck_of_cards', $deck);

        return $this->json([
            'drawn_cards' => $drawnCards,
            'remaining_cards' => $remainingCards
        ]);
    }
}
