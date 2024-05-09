<?php

namespace App\Card;

class CardGraphic extends Card
{
    public function getGraphicRepresentation(): string
    {
        $rank = $this->getRank();
        $suit = $this->getSuitSymbol();

        // For ranks greater than 10, use their corresponding names (Jack, Queen, King, Ace)
        $rank = ($rank == '10') ? $rank : substr($rank, 0, 1);

        return "[$rank$suit]";
    }

    protected function getSuitSymbol(): string
    {
        switch ($this->getSuit()) {
            case self::HEARTS:
                return '♥';
            case self::DIAMONDS:
                return '♦';
            case self::CLUBS:
                return '♣';
            case self::SPADES:
                return '♠';
            default:
                return '';
        }
    }
}
