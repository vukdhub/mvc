<?php

namespace App\Card;

class CardGraphic extends Card
{
    protected $graphic;

    public function __construct($suit, $rank, $graphic)
    {
        parent::__construct($suit, $rank);
        $this->graphic = $graphic;
    }

    public function getGraphic()
    {
        return $this->graphic;
    }

    public function getAsString(): string
    {
        return $this->rank . ' of ' . $this->suit . ' (Graphic: ' . $this->graphic . ')';
    }
}
