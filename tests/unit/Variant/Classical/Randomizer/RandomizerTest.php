<?php

namespace Chess\Tests\Unit\Variant\Classical\Randomizer;

use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Classical\Randomizer\Randomizer;

class RandomizerTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function kings()
    {
        $turn = Color::W;

        $board = (new Randomizer($turn))->getBoard();

        $this->assertNotEmpty($board->toFen());
    }

    /**
     * @test
     */
    public function w_N_B_R()
    {
        $turn = Color::W;

        $items = [
            Color::W => ['N', 'B', 'R'],
        ];

        $board = (new Randomizer($turn, $items))->getBoard();

        $this->assertNotEmpty($board->toFen());
    }

    /**
     * @test
     */
    public function b_N_B_R()
    {
        $turn = Color::B;

        $items = [
            Color::B => ['N', 'B', 'R'],
        ];

        $board = (new Randomizer($turn, $items))->getBoard();

        $this->assertNotEmpty($board->toFen());
    }
}
