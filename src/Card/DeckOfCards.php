<?php

namespace App\DeckOfCards;

use App\Card\CardGraphic;
use App\Card\Card;

class DeckOfCards
{
    /**
     * @var Card[]
     */
    protected array $cards;

    public function __construct()
    {
        $this->cards = [];
        $suits = ['Hearts', 'Diamonds', 'Clubs', 'Spades'];
        $ranks = ['Ace', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'Jack', 'Queen', 'King'];
        foreach ($suits as $suit) {
            foreach ($ranks as $rank) {
                $this->cards[] = new CardGraphic($suit, $rank);
            }
        }
    }

    public function shuffle(): bool
    {
        return shuffle($this->cards);
    }

    /**
     * @return Card|null
     */
    public function drawCard(): ?Card
    {
        return array_pop($this->cards);
    }

    /**
     * @return Card[]
     */
    public function getCards(): array
    {
        return $this->cards;
    }

    public function sort(): void
    {
        // Define a custom comparison function for sorting
        usort($this->cards, function ($a, $b) {
            // Compare suits first
            $suitOrder = ['Hearts' => 1, 'Diamonds' => 2, 'Clubs' => 3, 'Spades' => 4];
            $suitOrderA = $suitOrder[$a->getSuit()];
            $suitOrderB = $suitOrder[$b->getSuit()];

            if ($suitOrderA === $suitOrderB) {
                // If suits are equal, compare ranks
                $ranksOrder = ['Ace' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9, '10' => 10, 'Jack' => 11, 'Queen' => 12, 'King' => 13];
                $rankA = $ranksOrder[$a->getRank()];
                $rankB = $ranksOrder[$b->getRank()];
                return $rankA <=> $rankB; // Compare ranks
            }

            return $suitOrderA <=> $suitOrderB; // Compare suits
        });
    }

    public function drawRandomCard(): Card
    {
        $index = mt_rand(0, count($this->cards) - 1);
        return array_splice($this->cards, $index, 1)[0];
    }

    /**
     * @param int $number
     * @return Card[]
     */
    public function drawMultipleCards(int $number): array
    {
        $drawnCards = [];
        for ($i = 0; $i < $number; $i++) {
            if (!empty($this->cards)) {
                $drawnCards[] = $this->drawRandomCard();
            }
        }
        return $drawnCards;
    }
}
