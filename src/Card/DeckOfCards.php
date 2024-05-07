<?php

namespace App\DeckOfCards;

use App\Card\CardGraphic;
use App\Card\Card;

class DeckOfCards
{
    protected $cards;

    public function __construct()
    {
        $this->cards = [];
        $suits = ['Hearts', 'Diamonds', 'Clubs', 'Spades'];
        $ranks = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'Jack', 'Queen', 'King', 'Ace'];
        foreach ($suits as $suit) {
            foreach ($ranks as $rank) {
                $this->cards[] = new Card($suit, $rank);
            }
        }
    }

    public function shuffle()
    {
        shuffle($this->cards);
    }

    public function drawCard()
    {
        return array_pop($this->cards);
    }

    public function getCards()
    {
        return $this->cards;
    }

    public function sort()
    {
        // Define a custom comparison function for sorting
        usort($this->cards, function ($a, $b) {
            // Convert ranks to numeric values for comparison
            $ranks = ['2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9, '10' => 10, 'Jack' => 11, 'Queen' => 12, 'King' => 13, 'Ace' => 14];
            $rankA = $ranks[$a->getRank()];
            $rankB = $ranks[$b->getRank()];

            // Compare ranks
            if ($rankA == $rankB) {
                return 0;
            }
            return ($rankA < $rankB) ? -1 : 1;
        });
    }
}
