<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 */
class CardGraphicTest extends TestCase
{
    /**
     * Test that a CardGraphic object can be created.
     */
    public function testCreateCardGraphic(): void
    {
        $card = new CardGraphic(Card::HEARTS, 'Ace');

        $this->assertInstanceOf(CardGraphic::class, $card);
    }

    /**
     * Test graphic representation for a number card (2–9).
     */
    public function testGetSuitSymbol(): void
    {
        $card = new CardGraphic(Card::HEARTS, '7');
        $this->assertEquals('[7♥]', $card->getGraphicRepresentation());
    }

    /**
    * Test graphic representation for card with rank 10.
    */
    public function testGraphicRepresentationTen(): void
    {
        $card = new CardGraphic(Card::DIAMONDS, '10');

        $this->assertEquals('[10♦]', $card->getGraphicRepresentation());
    }

    /**
     * Test graphic representation for face cards.
     */
    public function testGraphicRepresentationFaceCard(): void
    {
        $card = new CardGraphic(Card::CLUBS, 'King');

        $this->assertEquals('[K♣]', $card->getGraphicRepresentation());
    }

    /**
     * Test that the correct suit symbol is used for each suit.
     */
    public function testSuitSymbols(): void
    {
        $this->assertEquals('[A♥]', (new CardGraphic(Card::HEARTS, 'Ace'))->getGraphicRepresentation());
        $this->assertEquals('[A♦]', (new CardGraphic(Card::DIAMONDS, 'Ace'))->getGraphicRepresentation());
        $this->assertEquals('[A♣]', (new CardGraphic(Card::CLUBS, 'Ace'))->getGraphicRepresentation());
        $this->assertEquals('[A♠]', (new CardGraphic(Card::SPADES, 'Ace'))->getGraphicRepresentation());
    }

    /**
     * Test that an unknown suit results in an empty suit symbol.
     */
    public function testGraphicRepresentationInvalidSuit(): void
    {
        $card = new CardGraphic('Wrong', 'Ace');

        $this->assertEquals('[A]', $card->getGraphicRepresentation());
    }
}