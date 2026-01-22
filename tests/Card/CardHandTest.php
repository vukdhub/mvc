<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class CardHand.
 */
class CardHandTest extends TestCase
{
    /**
     * Construct object and verify
     */
    public function testCreateCardHand(): void
    {
        $hand = new CardHand();

        $this->assertCount(0, $hand->getCards());
    }

    public function testAddCard(): void
    {
        $hand = new CardHand();
        $card = new Card(Card::SPADES, '5');

        $hand->addCard($card);

        $this->assertCount(1, $hand->getCards());
        $this->assertSame($card, $hand->getCards()[0]);
    }

    public function testGetTotalPointsWithoutAce(): void
    {
        $hand = new CardHand();
        $hand->addCard(new Card(Card::CLUBS, '10'));
        $hand->addCard(new Card(Card::DIAMONDS, '9'));

        $this->assertEquals(19, $hand->getTotalPoints());
    }

    public function testGetTotalPointsWithAce(): void
    {
        $hand = new CardHand();
        $hand->addCard(new Card(Card::HEARTS, 'Ace'));
        $hand->addCard(new Card(Card::SPADES, '10'));
        $hand->addCard(new Card(Card::CLUBS, '5'));

        $this->assertEquals(16, $hand->getTotalPoints());
    }

    public function testGameOverFalse(): void
    {
        $hand = new CardHand();
        $hand->addCard(new Card(Card::SPADES, '10'));
        $hand->addCard(new Card(Card::HEARTS, '9'));

        $this->assertFalse($hand->gameOver());
    }

    public function testGameOverTrue(): void
    {
        $hand = new CardHand();
        $hand->addCard(new Card(Card::SPADES, 'King'));
        $hand->addCard(new Card(Card::HEARTS, 'Queen'));

        $this->assertTrue($hand->gameOver());
    }
}