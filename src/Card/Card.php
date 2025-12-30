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


    protected string $suit;
    protected string $rank;

    public function __construct(string $suit, string $rank)
    {
        $this->suit = $suit;
        $this->rank = $rank;
    }

    public function getSuit(): string
    {
        return $this->suit;
    }

    public function getRank(): string
    {
        return $this->rank;
    }

    public function getSuitColor(): ?string
    {
        return self::SUIT_COLORS[$this->suit] ?? null;
    }

    public function getAsString(): string
    {
        return $this->rank . ' of ' . $this->suit;
    }

    public function getValue(): int
    {
        $rank = $this->rank;

        // Number cards 2–10
        if (is_numeric($rank)) {
            return (int)$rank;
        }

        return match ($rank) {
            'Ace' => 11,
            'Jack' => 12,
            'Queen', => 13,
            'King' => 14,
            default => 0
        };
    }
}
