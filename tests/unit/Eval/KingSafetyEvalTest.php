<?php

namespace Chess\Tests\Unit\Eval;

use Chess\Eval\KingSafetyEval;
use Chess\Play\SanPlay;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Classical\Board;

class KingSafetyEvalTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function start()
    {
        $expected = [
            'w' => 0,
            'b' => 0,
        ];

        $result = (new KingSafetyEval(new Board()))->getResult();

        $this->assertSame($expected, $result);
    }

    /**
     * @test
     */
    public function A00()
    {
        $expectedResult = [
            'w' => 1,
            'b' => 0,
        ];

        $expectedPhrase = [
            "The black pieces are timidly approaching the other side's king.",
        ];

        $A00 = file_get_contents(self::DATA_FOLDER.'/sample/A00.pgn');
        $board = (new SanPlay($A00))->validate()->board;
        $kingSafetyEval = new KingSafetyEval($board);

        $this->assertSame($expectedResult, $kingSafetyEval->getResult());
        $this->assertSame($expectedPhrase, $kingSafetyEval->getExplanation());
    }

    /**
     * @test
     */
    public function B25()
    {
        $expected = [
            'w' => 0,
            'b' => 0,
        ];

        $B25 = file_get_contents(self::DATA_FOLDER.'/sample/B25.pgn');
        $board = (new SanPlay($B25))->validate()->board;
        $result = (new KingSafetyEval($board))->getResult();

        $this->assertSame($expected, $result);
    }
}
