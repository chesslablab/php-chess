<?php

namespace Chess\Tests\Unit\Computer;

use Chess\Computer\GrandmasterMove;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Classical\Board;

class GrandmasterMoveTest extends AbstractUnitTestCase
{
    const FILEPATH = __DIR__.'/../../data/json/players.json';

    /**
     * @test
     */
    public function w_move()
    {
        $board = new Board();
        $move = (new GrandmasterMove(self::FILEPATH))->move($board);

        $this->assertNotEmpty($move);
    }

    /**
     * @test
     */
    public function b_move()
    {
        $board = new Board();
        $board->play('w', 'e4');
        $move = (new GrandmasterMove(self::FILEPATH))->move($board);

        $this->assertNotEmpty($move);
    }
}
