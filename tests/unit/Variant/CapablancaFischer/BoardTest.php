<?php

namespace Chess\Tests\Unit\Variant\CapablancaFischer;

use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Classical\PGN\Castle;
use Chess\Variant\Classical\PGN\Color;
use Chess\Variant\Classical\PGN\Piece;
use Chess\Variant\CapablancaFischer\Board;
use Chess\Variant\CapablancaFischer\Shuffle;

class BoardTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function pieces()
    {
        $shuffle = (new Shuffle())->shuffle();
        $board = new Board($shuffle);
        $pieces = $board->pieces();

        $this->assertSame(40, count($pieces));
    }

    /**
     * @test
     */
    public function castling_rule_ARBBKRQNNC()
    {
        $shuffle = ['A', 'R', 'B', 'B', 'K', 'R', 'Q', 'N', 'N', 'C'];

        $castlingRule = (new Board($shuffle))->castlingRule;

        $expected = [
            Color::W => [
                Castle::SHORT => [
                    'free' => [ 'g1', 'h1', 'i1' ],
                    'attack' => [ 'e1', 'f1', 'g1', 'h1', 'i1' ],
                    'k_from' => 'e1',
                    'k_to' => 'i1',
                    'r_from' => 'f1',
                    'r_to' => 'h1',
                ],
                Castle::LONG => [
                    'free' => [ 'c1', 'd1' ],
                    'attack' => [ 'c1', 'd1', 'e1' ],
                    'k_from' => 'e1',
                    'k_to' => 'c1',
                    'r_from' => 'b1',
                    'r_to' => 'd1',
                ],
            ],
            Color::B => [
                Castle::SHORT => [
                    'free' => [ 'g8', 'h8', 'i8' ],
                    'attack' => [ 'e8', 'f8', 'g8', 'h8', 'i8' ],
                    'k_from' => 'e8',
                    'k_to' => 'i8',
                    'r_from' => 'f8',
                    'r_to' => 'h8',
                ],
                Castle::LONG => [
                    'free' => [ 'c8', 'd8' ],
                    'attack' => [ 'c8', 'd8', 'e8' ],
                    'k_from' => 'e8',
                    'k_to' => 'c8',
                    'r_from' => 'b8',
                    'r_to' => 'd8',
                ],
            ],
        ];

        $this->assertEquals($expected, $castlingRule->rule);
    }

    /**
     * @test
     */
    public function play_AQRBKRBNNC_e4_e5()
    {
        $shuffle = ['A', 'Q', 'R', 'B', 'K', 'R', 'B', 'N', 'N', 'C'];

        $board = new Board($shuffle);

        $board->play('w', 'e4');
        $board->play('b', 'e5');

        $expected = [
            7 => [ 'a', 'q', 'r', 'b', 'k', 'r', 'b', 'n', 'n', 'c' ],
            6 => [ 'p', 'p', 'p', 'p', '.', 'p', 'p', 'p', 'p', 'p' ],
            5 => [ '.', '.', '.', '.', '.', '.', '.', '.', '.', '.' ],
            4 => [ '.', '.', '.', '.', 'p', '.', '.', '.', '.', '.' ],
            3 => [ '.', '.', '.', '.', 'P', '.', '.', '.', '.', '.' ],
            2 => [ '.', '.', '.', '.', '.', '.', '.', '.', '.', '.' ],
            1 => [ 'P', 'P', 'P', 'P', '.', 'P', 'P', 'P', 'P', 'P' ],
            0 => [ 'A', 'Q', 'R', 'B', 'K', 'R', 'B', 'N', 'N', 'C' ],
        ];

        $this->assertSame($expected, $board->toArray());
    }
}
