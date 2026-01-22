<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 */
class CardTest extends TestCase
{
    /**
     * Construct object and verify
     */
    public function testCreateCard(): void
    {
        $card = new Card(Card::HEARTS, 'A');

        $this->assertInstanceOf(Card::class, $card);

        $res = $card->getAsString();
        $this->assertNotEmpty($res);
        $this->assertStringContainsString('A', $res);
        $this->assertStringContainsString(Card::HEARTS, $res);
    }

    /**
     * Test that getSuit() returns the suit
     */
    public function testGetSuit(): void
    {
        $card = new Card(Card::SPADES, 'A');

        $this->assertEquals(Card::SPADES, $card->getSuit());
    }

    /**
     * Test that getRank() returns the rank
     */
    public function testGetRank(): void
    {
        $card = new Card(Card::SPADES, 'A');

        $this->assertEquals('A', $card->getRank());
    }

    /**
     * Test that getSuitColor() returns the correct color
     * for red suits (Hearts and Spades).
     */
    public function testGetSuitColor(): void
    {
        $card = new Card(Card::SPADES, 'A');
        $this->assertEquals('black', $card->getSuitColor());

        $card = new Card(Card::HEARTS, 'A');
        $this->assertEquals('red', $card->getSuitColor());
    }

    /**
     * Test that getValue() returns correct numeric values
     * for number cards (2–10) and for faces
     */
    public function testGetValue(): void
    {
        $card = new Card(Card::SPADES, '5');
        $this->assertEquals(5, $card->getValue());

        $card = new Card(Card::HEARTS, '10');
        $this->assertEquals(10, $card->getValue());

        $this->assertEquals(11, (new Card(Card::SPADES, 'Ace'))->getValue());
        $this->assertEquals(12, (new Card(Card::SPADES, 'Jack'))->getValue());
        $this->assertEquals(13, (new Card(Card::SPADES, 'Queen'))->getValue());
        $this->assertEquals(14, (new Card(Card::SPADES, 'King'))->getValue());
    }
}
