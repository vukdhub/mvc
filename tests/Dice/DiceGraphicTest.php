<?php
namespace App\Dice;

use PHPUnit\Framework\TestCase;

class MockDice extends Dice
{   
    protected int $value;

    public function __construct()
    {
        $this->value = 0;
    }
}

class DiceGraphicTest extends TestCase
{
    public function testCreateObject(): void
    {
        $dice = new MockDice();
        $this->assertInstanceOf(MockDice::class, $dice);
        $this->assertEquals(0, $dice->getValue());
    }


    public function testGetAsString(): void
    {
        $dice = new DiceGraphic();

        $dice->roll();
        $value = $dice->getValue();

        $symbols = ['⚀','⚁','⚂','⚃','⚄','⚅'];
        $expected = $symbols[$value - 1];

        $this->assertEquals($expected, $dice->getAsString());
    }
}