<?php

namespace App\Card;

class CardHand
{
    /**
     * @var Card[] 
     */
    protected $cards = [];

    public function __construct()
    {
        $this->cards = [];
    }

    public function addCard(Card $card): void
    {
        $this->cards[] = $card;
    }

    /**
     * @return Card[]
     */
    public function getCards(): array
    {
        return $this->cards;
    }

    public function getTotalPoints(): int
    {
        $total = 0;
        $aces = 0;

        foreach ($this->cards as $card) {
            $value = $card->getValue();
            if ($card->getRank() === 'Ace') {
                $aces++;
            }
            $total += $value;
        }

        while ($total > 21 && $aces > 0) {
            $total -= 10;
            $aces--;
        }

        return $total;
    }

    public function gameOver(): bool
    {
        return $this->getTotalPoints() > 21;
    }
}
