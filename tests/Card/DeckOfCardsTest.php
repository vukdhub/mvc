<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;
use App\Card\DeckOfCards;

/**
 * Test cases for class Card.
 */
class DeckOfCardsTest extends TestCase
{

    public function testCreateDeck(): void
    {
        $deck = new DeckOfCards();
        
        $this->assertInstanceOf(DeckOfCards::class, $deck);
        $this->assertCount(52, $deck->getCards());
    }

    /**
     * Test that all cards in the deck are CardGraphic objects.
     */
    public function testDeckContainsOnlyCardGraphic(): void
    {
        $deck = new DeckOfCards();

        foreach ($deck->getCards() as $card) {
            $this->assertInstanceOf(CardGraphic::class, $card);
        }
    }

    /**
     * Test that shuffling the deck returns true
     * and does not change the number of cards.
     */
    public function testShuffleDeck(): void
    {
        $deck = new DeckOfCards();

        $result = $deck->shuffle();

        $this->assertTrue($result);
        $this->assertCount(52, $deck->getCards());
    }

    /**
     * Test that sorting the deck keeps 52 cards
     * and does not remove any cards.
     */
    public function testSortDeck(): void
    {
        $deck = new DeckOfCards();

        $deck->shuffle();
        $deck->sort();

        $this->assertCount(52, $deck->getCards());
    }

    public function testDrawReducesDeckSize(): void
    {
        $deck = new DeckOfCards();

        $deck->drawRandomCard();
        $this->assertCount(51, $deck->getCards());
    }

    public function testMultiDraw(): void
    {
        $deck = new DeckOfCards();

        $deck->drawMultipleCards(10);
        $this->assertCount(42, $deck->getCards());
    }

    /**
     * Test that drawing all cards 
     */
    public function testDrawCardWhenDeckIsEmpty(): void
    {
        $deck = new DeckOfCards();

        for ($i = 0; $i < 52; $i++) {
            $deck->drawCard();
        }

        $this->assertNull($deck->drawCard());
    }
}