<?php

namespace App\Card;

class CardHand
{
    protected $cards;

    public function __construct()
    {
        $this->cards = [];
    }

    public function addCard(Card $card)
    {
        $this->cards[] = $card;
    }

    public function getCards()
    {
        return $this->cards;
    }
}
