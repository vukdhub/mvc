<?php

namespace App\Controller;

use App\DeckOfCards\DeckOfCards;
use App\Card\CardHand;
use App\Card\CardGraphic;
use App\Functions\Game21Finish;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Game21Controller extends AbstractController
{
    #[Route("/game21/", name: "game_21")]
    public function game21(SessionInterface $session): Response
    {
        $session->clear();
        return $this->render('game21/index.html.twig');
    }

    #[Route("/game21/play21", name: "play_21")]
    public function play21(SessionInterface $session): Response
    {
        // Load players hand or create a new one
        $hand = $session->get('player_hand', new CardHand());
        $session->set('player_hand', $hand);

        $state = $session->get('game_state', 'playing');

        // Load drawn cards for display
        $drawnCards = $hand->getCards();

        $total = $hand->getTotalPoints();

        // Dealer data aftet STOp
        $dealerHand = $session->get('dealer_hand', null);
        $dealerTotal = $dealerHand ? $dealerHand->getTotalPoints() : null;

        $result = $session->get('result', null);

        return $this->render('game21/play21.html.twig', [
            'drawnCards' => $drawnCards,
            'total' => $total,
            'message' => $session->get('message', ''),
            'dealerHand' => $dealerHand,
            'dealerTotal' => $dealerTotal,
            'result' => $result,
            'gameState' => $state,
        ]);
    }

    #[Route("/game21/draw", name: "game_21_draw", methods: ["POST"])]
    public function drawCard(SessionInterface $session): RedirectResponse
    {
        if ($session->get('game_state') === 'ended') {
            return $this->redirectToRoute('play_21');
        }

        $deck = $session->get('deck_of_cards', new DeckOfCards());
        // Save updated deck
        $session->set('deck_of_cards', $deck);

        // Load players hand
        $hand = $session->get('player_hand', new CardHand());

        // Draw a card
        $drawnCard = $deck->drawRandomCard();

        // Add card to the player's hand
        $hand->addCard($drawnCard);


        // Save updated deck and hand
        $session->set('player_hand', $hand);
        $session->set('deck_of_cards', $deck);

        // Cheking results
        if ($hand->gameOver()) {
            $session->set('game_state', 'ended');
            $session->set('result', 'dealer');
            $session->set('message', 'You exceeded 21. You lose.');
        }

        return $this->redirectToRoute('play_21');
    }

    #[Route("/game21/endgame", name: "game_21_stop", methods: ["POST"])]
    public function endGame(SessionInterface $session, Game21Finish $game21): RedirectResponse
    {
        $deck = $session->get('deck_of_cards');
        $playerHand = $session->get('player_hand');

        $resultData = $game21->finishGame($deck, $playerHand);

        $session->set('dealer_hand', $resultData['dealer_hand']);
        $session->set('result', $resultData['result']);
        $session->set('game_state', 'ended');

        return $this->redirectToRoute('play_21');
    }

    #[Route("/game21/reset", name: "game_21_reset", methods: ["POST"])]
    public function reset(SessionInterface $session): RedirectResponse
    {
        $session->clear();
        return $this->redirectToRoute('play_21');
    }

    #[Route("/api/game21", name: "play_21_api")]
    public function game21Api(SessionInterface $session): Response
    {
        // Get or create player hand
        $playerHand = $session->get('player_hand', new \App\Card\CardHand());
        $session->set('player_hand', $playerHand);

        // Get or create dealer hand
        $dealerHand = $session->get('dealer_hand', new \App\Card\CardHand());
        $session->set('dealer_hand', $dealerHand);

        // Format array
        $formatCards = fn ($hand) => array_map(fn ($card) => [
            'value' => $card->getRank(),
            'suit' => $card->getSuit(),
        ], $hand->getCards());

        return $this->json([
            'player' => $formatCards($playerHand),
            'playerTotal' => $playerHand->getTotalPoints(),
            'bank' => $formatCards($dealerHand),
            'bankTotal' => $dealerHand->getTotalPoints(),
        ]);
    }

    #[Route("/game21/doc", name: "doc")]
    public function gameDoc(SessionInterface $session): Response
    {
        return $this->render('game21/doc.html.twig');
    }

}
