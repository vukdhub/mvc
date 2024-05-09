<?php

namespace App\Card;

class Card
{
    public const HEARTS = 'Hearts';
    public const DIAMONDS = 'Diamonds';
    public const CLUBS = 'Clubs';
    public const SPADES = 'Spades';

    public const SUIT_COLORS = [
        self::HEARTS   => 'red',
        self::DIAMONDS => 'red',
        self::CLUBS    => 'black',
        self::SPADES   => 'black',
    ];


    protected $suit;
    protected $rank;

    public function __construct($suit, $rank)
    {
        $this->suit = $suit;
        $this->rank = $rank;
    }

    public function getSuit()
    {
        return $this->suit;
    }

    public function getRank()
    {
        return $this->rank;
    }

    public function getSuitColor()
    {
        return self::SUIT_COLORS[$this->suit] ?? null;
    }

    public function getAsString(): string
    {
        return $this->rank . ' of ' . $this->suit;
    }
}
