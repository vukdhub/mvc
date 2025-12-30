<?php

namespace App\Functions;

use App\Card\CardHand;
use App\DeckOfCards\DeckOfCards;

class Game21Finish
{
    /**
     * @return array{
     *     dealer_hand: CardHand,
     *     result: string
     * }
     */
    public function finishGame(DeckOfCards $deck, CardHand $playerHand): array
    {
        $dealerHand = new CardHand();

        while ($dealerHand->getTotalPoints() < 17) {
            $dealerHand->addCard($deck->drawRandomCard());
        }

        $playerTotal = $playerHand->getTotalPoints();
        $dealerTotal = $dealerHand->getTotalPoints();

        if ($dealerTotal > 21) {
            $result = "player";
        } elseif ($dealerTotal >= $playerTotal) {
            $result = "dealer";
        } else {
            $result = "player";
        }

        return [
            'dealer_hand' => $dealerHand,
            'result' => $result,
        ];
    }
}
