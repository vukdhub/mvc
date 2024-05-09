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
        // Get and dump the session data for debugging
        $sessionData = $session->all();
        dump($sessionData);

        return $this->render('/cardgame/session.html.twig', [
            'sessionData' => $sessionData,
        ]);
    }

    #[Route("/session/delete", name: "delete_session")]
    public function deleteSession(SessionInterface $session): Response
    {
        // Clear all data in the session
        $session->clear();

        // Add a flash message to provide feedback to the user
        $this->addFlash('success', 'Session has been cleared.');

        // Redirect back to the landing page
        return $this->redirectToRoute('landing_page');
    }

    #[Route("/game/card", name: "card_game")]
    public function cards()
    {
        return $this->render('/cardgame/home.html.twig');
    }

    #[Route("/game/card/shuffle", name: "shuffle_game")]
    public function displayDeck(
        SessionInterface $session
    ): Response {

        $session->clear();

        $deck = new DeckOfCards();
        $deck->shuffle(); // Shuffle the deck

        // Store the deck in the session
        $session->set('deck', $deck);

        // Pass the cards to the Twig template
        return $this->render('cardgame/shuffle.html.twig', [
            'cards' => $deck->getCards(),
        ]);
    }

    #[Route("/game/card/sorted", name: "sorted_cards")]
    public function displaySortedCards(SessionInterface $session): Response
    {
        // Clear the session
        $session->clear();

        // Create a new deck
        $deck = new DeckOfCards();

        // Sort the cards
        $deck->sort(); // You need to implement this method in DeckOfCards class

        // Store the deck in the session
        $session->set('deck', $deck);

        // Pass the sorted cards to the Twig template
        return $this->render('cardgame/sorted.html.twig', [
            'cards' => $deck->getCards(),
        ]);
    }


    #[Route("/card/deck/draw", name: "draw_card")]
    public function drawCard(SessionInterface $session): Response
    {
        // Get the deck of cards from the session or create a new one if it doesn't exist
        $deck = $session->get('deck_of_cards', new DeckOfCards());

        // Draw a single card from the deck
        $drawnCard = $deck->drawRandomCard();

        // Store the drawn card in the session
        $drawnCards = $session->get('drawn_cards', []);
        $drawnCards[] = $drawnCard;
        $session->set('drawn_cards', $drawnCards);

        // Update the session to reflect the number of remaining cards
        $remainingCards = count($deck->getCards());
        $session->set('remaining_cards', $remainingCards);

        // Update or set the deck of cards in the session
        $session->set('deck_of_cards', $deck);

        // Render the response (you might want to adjust this based on your application)
        return $this->render('cardgame/draw_card.html.twig', [
            'drawn_card' => $drawnCard,
            'remaining_cards' => $remainingCards
        ]);
    }

    // #[Route("/card/deck/draw/{number}", name: "draw_multiple_cards")]
    // public function drawMultipleCards(int $number, SessionInterface $session): Response
    // {
    //     // Implement logic to draw multiple cards
    // }

}
