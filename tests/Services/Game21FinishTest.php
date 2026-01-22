<?php
namespace App\Services;

use PHPUnit\Framework\TestCase;
use App\Services\Game21Finish;
use App\Card\CardHand;
use App\Card\DeckOfCards;
use App\Card\Card;

/**
 * Test cases for class Game21Finish.
 */
class Game21FinishTest extends TestCase
{

    public function testPlayerWins() : void
    {
        $game = new Game21Finish();

        $deck = $this->createMock(DeckOfCards::class);
        $bigCard = $this->createMock(Card::class);
        $deck->method('drawRandomCard')->willReturn($bigCard);

        $playerHand = new CardHand();
        $playerHand->addCard(new Card('10', 'hearts'));
        $playerHand->addCard(new Card('9', 'spades'));

        $dealerHandMock = $this->createMock(CardHand::class);
        $dealerHandMock->expects($this->atLeastOnce())
            ->method('getTotalPoints')
            ->willReturnOnConsecutiveCalls(15, 22, 22);


        $result = $game->finishGame($deck, $playerHand, $dealerHandMock);

        $this->assertEquals('player', $result['result']);
    }


    public function testDealerWins(): void
    {
        $service = new Game21Finish();
        $deck = $this->createMock(DeckOfCards::class);

        $playerHand = $this->createMock(CardHand::class);
        $playerHand->method('getTotalPoints')->willReturn(16);

        $dealerHand = $this->createMock(CardHand::class);
        $dealerHand->method('getTotalPoints')->willReturn(17);

        $result = $service->finishGame($deck, $playerHand, $dealerHand);

        $this->assertEquals('dealer', $result['result']);
    }

     public function testPlayerWinsPoints(): void
    {
        $service = new Game21Finish();
        $deck = $this->createMock(DeckOfCards::class);

        $playerHand = $this->createMock(CardHand::class);
        $playerHand->method('getTotalPoints')->willReturn(20);

        $dealerHand = $this->createMock(CardHand::class);
        $dealerHand->method('getTotalPoints')->willReturn(17);

        $result = $service->finishGame($deck, $playerHand, $dealerHand);

        $this->assertEquals('player', $result['result']);
    }

}