<?php

namespace App\Controller;

use App\DeckOfCards\DeckOfCards;
use App\Card\CardHand;
use App\Card\CardGraphic;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CardGameController extends AbstractController
{
    #[Route("/session/", name: "landing_page")]
    public function landingPage(SessionInterface $session): Response
    {
        $sessionData = $session->all();
        dump($sessionData);

        return $this->render('/cardgame/session.html.twig', [
            'sessionData' => $sessionData,
        ]);
    }

    #[Route("/session/delete", name: "delete_session")]
    public function deleteSession(SessionInterface $session): Response
    {
        $session->clear();

        $this->addFlash('success', 'Session has been cleared.');

        return $this->redirectToRoute('landing_page');
    }

    #[Route("/game/card", name: "card_game")]
    public function cards(): Response
    {
        $imageUrl = [
            'imageUrl' => './img/umlcardgame.jpg',
        ];
        return $this->render('/cardgame/home.html.twig', $imageUrl);
    }

    #[Route("/game/card/shuffle", name: "shuffle_game")]
    public function displayDeck(
        SessionInterface $session
    ): Response {

        $session->clear();

        $deck = new DeckOfCards();
        $deck->shuffle();

        $session->set('deck', $deck);

        return $this->render('cardgame/shuffle.html.twig', [
            'cards' => $deck->getCards(),
        ]);
    }

    #[Route("/game/card/sorted", name: "sorted_cards")]
    public function displaySortedCards(SessionInterface $session): Response
    {
        $session->clear();

        $deck = new DeckOfCards();

        $deck->sort();

        $session->set('deck', $deck);

        return $this->render('cardgame/sorted.html.twig', [
            'cards' => $deck->getCards(),
        ]);
    }


    #[Route("/card/deck/draw", name: "draw_card")]
    public function drawCard(SessionInterface $session): Response
    {
        $deck = $session->get('deck_of_cards', new DeckOfCards());

        $drawnCard = $deck->drawRandomCard();

        $drawnCards = $session->get('drawn_cards', []);
        $drawnCards[] = $drawnCard;
        $session->set('drawn_cards', $drawnCards);

        $remainingCards = count($deck->getCards());
        $session->set('remaining_cards', $remainingCards);

        $session->set('deck_of_cards', $deck);

        return $this->render('cardgame/draw_card.html.twig', [
            'drawn_card' => $drawnCard,
            'remaining_cards' => $remainingCards
        ]);
    }

    #[Route("/game/card/deck/draw/{number<\d+>?5}", name: "draw_cards")]
    public function drawCards(SessionInterface $session, int $number = 5): Response
    {
        $deck = $session->get('deck_of_cards', new DeckOfCards());

        $drawnCards = $deck->drawMultipleCards($number);

        $drawnCardsSession = $session->get('drawn_cards', []);
        $drawnCardsSession = array_merge($drawnCardsSession, $drawnCards);
        $session->set('drawn_cards', $drawnCardsSession);

        $remainingCards = count($deck->getCards());
        $session->set('remaining_cards', $remainingCards);

        $session->set('deck_of_cards', $deck);

        return $this->render('cardgame/draw_multi_cards.html.twig', [
            'drawn_cards' => $drawnCards,
            'remaining_cards' => $remainingCards
        ]);
    }

}
