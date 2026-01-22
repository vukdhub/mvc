<?php

namespace App\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class.
 */
class DiceHandTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties.
     */
    public function testCreateObject(): void
    {
        $dicehand = new DiceHand();
        $this->assertInstanceOf(DiceHand::class, $dicehand);
    }

    /**
     * Roll dicehand and check the value is in range.
     */
    public function testAddDices(): void
    {
        $dicehand = new DiceHand();
        $dicehand->add(new Dice());
        $dicehand->add(new Dice());
        $dicehand->roll();
        $res = $dicehand->getValues();
        $total = array_sum($res);
        $this->assertGreaterThanOrEqual(2, $total);
        $this->assertLessThanOrEqual(12, $total);
    }

    /**
     * Test that getNumberDices() returns correct count
     */
    public function testGetNumberDices(): void
    {
        $dicehand = new DiceHand();
        $this->assertEquals(0, $dicehand->getNumberDices());

        $dicehand->add(new DiceGraphic());
        $dicehand->add(new DiceGraphic());

        $this->assertEquals(2, $dicehand->getNumberDices());
    }

    /**
     * Stub the dices to assure the value can be asserted.
     */
    public function testAddStubbedDices(): void
    {
        // Use stubs to control dice faces
        $stub1 = $this->createStub(DiceGraphic::class);
        $stub1->method('getAsString')->willReturn('⚀');

        $stub2 = $this->createStub(DiceGraphic::class);
        $stub2->method('getAsString')->willReturn('⚁');

        $dicehand = new DiceHand();
        $dicehand->add($stub1);
        $dicehand->add($stub2);

        $res = $dicehand->getString();

        $this->assertNotEmpty($res);
        $this->assertCount(2, $res);
        $this->assertEquals(['⚀','⚁'], $res);
    }
}
