<?php

namespace Chess\Tests\Unit\Variant\Chess960;

use Chess\PgnParser;
use Chess\Play\SanPlay;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Classical\PGN\Castle;
use Chess\Variant\Classical\PGN\Color;
use Chess\Variant\Classical\PGN\Move;
use Chess\Variant\Chess960\Board;
use Chess\Variant\Chess960\FenToBoardFactory;
use Chess\Variant\Chess960\Shuffle;

class BoardTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function sample_chess960()
    {
        $expected = [
            'total' => 90,
            'valid' => 90,
        ];

        $parser = new PgnParser(new Move(), self::DATA_FOLDER . "/sample/" . "chess960.pgn");

        $parser->onValidation(function(array $tags, string $movetext) {
            $board = FenToBoardFactory::create($tags['FEN']);
            (new SanPlay($movetext, $board))->validate();
        });
        
        $parser->parse();

        $this->assertEquals($expected, $parser->getResult());
    }

    /**
     * @test
     */
    public function pieces()
    {
        $shuffle = (new Shuffle())->shuffle();
        $board = new Board($shuffle);
        $pieces = $board->pieces();

        $this->assertSame(32, count($pieces));
    }

    /**
     * @test
     */
    public function castling_rule_RBBKRQNN()
    {
        $shuffle = ['R', 'B', 'B', 'K', 'R', 'Q', 'N', 'N'];

        $castlingRule = (new Board($shuffle))->castlingRule;

        $expected = [
            Color::W => [
                Castle::SHORT => [
                    [ 'f1', 'g1' ],
                    [ 'd1', 'e1', 'f1', 'g1' ],
                    [ 'd1', 'g1' ],
                    [ 'e1', 'f1' ],
                ],
                Castle::LONG => [
                    [ 'b1', 'c1' ],
                    [ 'c1', 'd1' ],
                    [ 'd1', 'c1' ],
                    [ 'a1', 'd1' ],
                ],
            ],
            Color::B => [
                Castle::SHORT => [
                    [ 'f8', 'g8' ],
                    [ 'd8', 'e8', 'f8', 'g8' ],
                    [ 'd8', 'g8' ],
                    [ 'e8', 'f8' ],
                ],
                Castle::LONG => [
                    [ 'b8', 'c8' ],
                    [ 'c8', 'd8' ],
                    [ 'd8', 'c8' ],
                    [ 'a8', 'd8' ],
                ],
            ],
        ];

        $this->assertEquals($expected, $castlingRule->rule);
    }

    /**
     * @test
     */
    public function castling_rule_QRBKRBNN()
    {
        $shuffle = ['Q', 'R', 'B', 'K', 'R', 'B', 'N', 'N'];

        $castlingRule = (new Board($shuffle))->castlingRule;

        $expected = [
            Color::W => [
                Castle::SHORT => [
                    [ 'f1', 'g1' ],
                    [ 'd1', 'e1', 'f1', 'g1' ],
                    [ 'd1', 'g1' ],
                    [ 'e1', 'f1' ],
                ],
                Castle::LONG => [
                    [ 'c1' ],
                    [ 'c1', 'd1' ],
                    [ 'd1', 'c1' ],
                    [ 'b1', 'd1' ],
                ],
            ],
            Color::B => [
                Castle::SHORT => [
                    [ 'f8', 'g8' ],
                    [ 'd8', 'e8', 'f8', 'g8' ],
                    [ 'd8', 'g8' ],
                    [ 'e8', 'f8' ],
                ],
                Castle::LONG => [
                    [ 'c8' ],
                    [ 'c8', 'd8' ],
                    [ 'd8', 'c8' ],
                    [ 'b8', 'd8' ],
                ],
            ],
        ];

        $this->assertEquals($expected, $castlingRule->rule);
    }

    /**
     * @test
     */
    public function castling_rule_BQNRKBRN()
    {
        $shuffle = ['B', 'Q', 'N', 'R', 'K', 'B', 'R', 'N'];

        $castlingRule = (new Board($shuffle))->castlingRule;

        $expected = [
            Color::W => [
                Castle::SHORT => [
                    [ 'f1' ],
                    [ 'e1', 'f1', 'g1' ],
                    [ 'e1', 'g1' ],
                    [ 'g1', 'f1' ],
                ],
                Castle::LONG => [
                    [ 'c1' ],
                    [ 'c1', 'd1', 'e1' ],
                    [ 'e1', 'c1' ],
                    [ 'd1', 'd1' ],
                ],
            ],
            Color::B => [
                Castle::SHORT => [
                    [ 'f8' ],
                    [ 'e8', 'f8', 'g8' ],
                    [ 'e8', 'g8' ],
                    [ 'g8', 'f8' ],
                ],
                Castle::LONG => [
                    [ 'c8' ],
                    [ 'c8', 'd8', 'e8' ],
                    [ 'e8', 'c8' ],
                    [ 'd8', 'd8' ],
                ],
            ],
        ];

        $this->assertEquals($expected, $castlingRule->rule);
    }

    /**
     * @test
     */
    public function play_QRBKRBNN_e4_e5()
    {
        $shuffle = ['Q', 'R', 'B', 'K', 'R', 'B', 'N', 'N'];

        $board = new Board($shuffle);

        $board->play('w', 'e4');
        $board->play('b', 'e5');

        $expected = [
            7 => [ 'q', 'r', 'b', 'k', 'r', 'b', 'n', 'n' ],
            6 => [ 'p', 'p', 'p', 'p', '.', 'p', 'p', 'p' ],
            5 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            4 => [ '.', '.', '.', '.', 'p', '.', '.', '.' ],
            3 => [ '.', '.', '.', '.', 'P', '.', '.', '.' ],
            2 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            1 => [ 'P', 'P', 'P', 'P', '.', 'P', 'P', 'P' ],
            0 => [ 'Q', 'R', 'B', 'K', 'R', 'B', 'N', 'N' ],
        ];

        $this->assertSame($expected, $board->toArray());
    }

    /**
     * @test
     */
    public function play_BBNRKRQN_e4_e5()
    {
        $shuffle = ['B', 'B', 'N', 'R', 'K', 'R', 'Q', 'N'];

        $board = new Board($shuffle);

        $board->play('w', 'e4');
        $board->play('b', 'e5');

        $expected = [
            7 => [ 'b', 'b', 'n', 'r', 'k', 'r', 'q', 'n' ],
            6 => [ 'p', 'p', 'p', 'p', '.', 'p', 'p', 'p' ],
            5 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            4 => [ '.', '.', '.', '.', 'p', '.', '.', '.' ],
            3 => [ '.', '.', '.', '.', 'P', '.', '.', '.' ],
            2 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            1 => [ 'P', 'P', 'P', 'P', '.', 'P', 'P', 'P' ],
            0 => [ 'B', 'B', 'N', 'R', 'K', 'R', 'Q', 'N' ],
        ];

        $this->assertSame($expected, $board->toArray());
    }

    /**
     * @test
     */
    public function play_NRNQKBBR_e4_Nd6_Bc4_e6_f3_Qe7_Bf2()
    {
        $shuffle = ['N', 'R', 'N', 'Q', 'K', 'B', 'B', 'R'];

        $board = new Board($shuffle);

        $board->play('w', 'e4');
        $board->play('b', 'Nd6');

        $board->play('w', 'Bc4');
        $board->play('b', 'e6');

        $board->play('w', 'f3');
        $board->play('b', 'Qe7');

        $board->play('w', 'Bf2');

        $expected = [
            7 => [ 'n', 'r', '.', '.', 'k', 'b', 'b', 'r' ],
            6 => [ 'p', 'p', 'p', 'p', 'q', 'p', 'p', 'p' ],
            5 => [ '.', '.', '.', 'n', 'p', '.', '.', '.' ],
            4 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            3 => [ '.', '.', 'B', '.', 'P', '.', '.', '.' ],
            2 => [ '.', '.', '.', '.', '.', 'P', '.', '.' ],
            1 => [ 'P', 'P', 'P', 'P', '.', 'B', 'P', 'P' ],
            0 => [ 'N', 'R', 'N', 'Q', 'K', '.', '.', 'R' ],
        ];

        $this->assertSame($expected, $board->toArray());
    }

    /**
     * @test
     */
    public function play_NRNQKBBR_e4_Nd6_Bc4_e6_f3_Qe7_Bf2_O_O_O()
    {
        $shuffle = ['N', 'R', 'N', 'Q', 'K', 'B', 'B', 'R'];

        $board = new Board($shuffle);

        $board->play('w', 'e4');
        $board->play('b', 'Nd6');

        $board->play('w', 'Bc4');
        $board->play('b', 'e6');

        $board->play('w', 'f3');
        $board->play('b', 'Qe7');

        $board->play('w', 'Bf2');
        $board->play('b', 'O-O-O');

        $expected = [
            7 => [ 'n', '.', 'k', 'r', '.', 'b', 'b', 'r' ],
            6 => [ 'p', 'p', 'p', 'p', 'q', 'p', 'p', 'p' ],
            5 => [ '.', '.', '.', 'n', 'p', '.', '.', '.' ],
            4 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            3 => [ '.', '.', 'B', '.', 'P', '.', '.', '.' ],
            2 => [ '.', '.', '.', '.', '.', 'P', '.', '.' ],
            1 => [ 'P', 'P', 'P', 'P', '.', 'B', 'P', 'P' ],
            0 => [ 'N', 'R', 'N', 'Q', 'K', '.', '.', 'R' ],
        ];

        $this->assertSame($expected, $board->toArray());
    }

    /**
     * @test
     */
    public function play_BBRQNNKR_Ne3_Ne6_O_O()
    {
        $shuffle = ['B', 'B', 'R', 'Q', 'N', 'N', 'K', 'R'];

        $board = new Board($shuffle);

        $this->assertTrue($board->play('w', 'Ne3'));
        $this->assertTrue($board->play('b', 'Ne6'));
        $this->assertTrue($board->play('w', 'O-O'));

        $expected = [
            7 => [ 'b', 'b', 'r', 'q', 'n', '.', 'k', 'r' ],
            6 => [ 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p' ],
            5 => [ '.', '.', '.', '.', 'n', '.', '.', '.' ],
            4 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            3 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            2 => [ '.', '.', '.', '.', 'N', '.', '.', '.' ],
            1 => [ 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P' ],
            0 => [ 'B', 'B', 'R', 'Q', 'N', 'R', 'K', '.' ],
        ];

        $this->assertSame($expected, $board->toArray());
    }

    /**
     * @test
     */
    public function play_BQNRKBRN_e3_g6_Bc4_Bh6()
    {
        $shuffle = ['B', 'Q', 'N', 'R', 'K', 'B', 'R', 'N'];

        $board = new Board($shuffle);

        $this->assertTrue($board->play('w', 'e3'));
        $this->assertTrue($board->play('b', 'g6'));
        $this->assertTrue($board->play('w', 'Bc4'));
        $this->assertTrue($board->play('b', 'Bh6'));

        $expected = [
            7 => [ 'b', 'q', 'n', 'r', 'k', '.', 'r', 'n' ],
            6 => [ 'p', 'p', 'p', 'p', 'p', 'p', '.', 'p' ],
            5 => [ '.', '.', '.', '.', '.', '.', 'p', 'b' ],
            4 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            3 => [ '.', '.', 'B', '.', '.', '.', '.', '.' ],
            2 => [ '.', '.', '.', '.', 'P', '.', '.', '.' ],
            1 => [ 'P', 'P', 'P', 'P', '.', 'P', 'P', 'P' ],
            0 => [ 'B', 'Q', 'N', 'R', 'K', '.', 'R', 'N' ],
        ];

        $this->assertSame($expected, $board->toArray());
    }

    /**
     * @test
     */
    public function play_BQNRKBRN_e3_g6_Bc4_Bh6_a3()
    {
        $shuffle = ['B', 'Q', 'N', 'R', 'K', 'B', 'R', 'N'];

        $board = new Board($shuffle);

        $this->assertTrue($board->play('w', 'e3'));
        $this->assertTrue($board->play('b', 'g6'));
        $this->assertTrue($board->play('w', 'Bc4'));
        $this->assertTrue($board->play('b', 'Bh6'));
        $this->assertTrue($board->play('w', 'a3'));

        $expected = [
            7 => [ 'b', 'q', 'n', 'r', 'k', '.', 'r', 'n' ],
            6 => [ 'p', 'p', 'p', 'p', 'p', 'p', '.', 'p' ],
            5 => [ '.', '.', '.', '.', '.', '.', 'p', 'b' ],
            4 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            3 => [ '.', '.', 'B', '.', '.', '.', '.', '.' ],
            2 => [ 'P', '.', '.', '.', 'P', '.', '.', '.' ],
            1 => [ '.', 'P', 'P', 'P', '.', 'P', 'P', 'P' ],
            0 => [ 'B', 'Q', 'N', 'R', 'K', '.', 'R', 'N' ],
        ];

        $this->assertSame($expected, $board->toArray());
    }

    /**
     * @test
     */
    public function play_NRQBBKRN_O_O()
    {
        $shuffle = ['N', 'R', 'Q', 'B', 'B', 'K', 'R', 'N'];

        $board = new Board($shuffle);

        $this->assertTrue($board->play('w', 'O-O'));

        $expected = [
            7 => [ 'n', 'r', 'q', 'b', 'b', 'k', 'r', 'n' ],
            6 => [ 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p' ],
            5 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            4 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            3 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            2 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            1 => [ 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P' ],
            0 => [ 'N', 'R', 'Q', 'B', 'B', 'R', 'K', 'N' ],
        ];

        $this->assertSame($expected, $board->toArray());
    }

    /**
     * @test
     */
    public function play_BNQRKRNB_Nf3_b6_O_O()
    {
        $shuffle = ['B', 'N', 'Q', 'R', 'K', 'R', 'N', 'B'];

        $board = new Board($shuffle);

        $this->assertTrue($board->play('w', 'Nf3'));
        $this->assertTrue($board->play('b', 'b6'));
        $this->assertTrue($board->play('w', 'O-O'));

        $expected = [
            7 => [ 'b', 'n', 'q', 'r', 'k', 'r', 'n', 'b' ],
            6 => [ 'p', '.', 'p', 'p', 'p', 'p', 'p', 'p' ],
            5 => [ '.', 'p', '.', '.', '.', '.', '.', '.' ],
            4 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            3 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            2 => [ '.', '.', '.', '.', '.', 'N', '.', '.' ],
            1 => [ 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P' ],
            0 => [ 'B', 'N', 'Q', 'R', '.', 'R', 'K', 'B' ],
        ];

        $this->assertSame($expected, $board->toArray());
    }

    /**
     * @test
     */
    public function play_QBBNRNKR_Nf1e3_Nd8e6_Kf1()
    {
        $shuffle = ['Q', 'B', 'B', 'N', 'R', 'N', 'K', 'R'];

        $board = new Board($shuffle);

        $this->assertTrue($board->play('w', 'Nf1e3'));
        $this->assertTrue($board->play('b', 'Nd8e6'));
        $this->assertTrue($board->play('w', 'Kf1'));

        $expected = [
            7 => [ 'q', 'b', 'b', '.', 'r', 'n', 'k', 'r' ],
            6 => [ 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p' ],
            5 => [ '.', '.', '.', '.', 'n', '.', '.', '.' ],
            4 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            3 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            2 => [ '.', '.', '.', '.', 'N', '.', '.', '.' ],
            1 => [ 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P' ],
            0 => [ 'Q', 'B', 'B', 'N', 'R', 'K', '.', 'R' ],
        ];

        $this->assertSame($expected, $board->toArray());
    }

    /**
     * @test
     */
    public function play_QBBNRNKR_Nf1e3_Nd8e6_O_O()
    {
        $shuffle = ['Q', 'B', 'B', 'N', 'R', 'N', 'K', 'R'];

        $board = new Board($shuffle);

        $this->assertTrue($board->play('w', 'Nf1e3'));
        $this->assertTrue($board->play('b', 'Nd8e6'));
        $this->assertTrue($board->play('w', 'O-O'));

        $expected = [
            7 => [ 'q', 'b', 'b', '.', 'r', 'n', 'k', 'r' ],
            6 => [ 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p' ],
            5 => [ '.', '.', '.', '.', 'n', '.', '.', '.' ],
            4 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            3 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            2 => [ '.', '.', '.', '.', 'N', '.', '.', '.' ],
            1 => [ 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P' ],
            0 => [ 'Q', 'B', 'B', 'N', 'R', 'R', 'K', '.' ],
        ];

        $this->assertSame($expected, $board->toArray());
    }

    /**
     * @test
     */
    public function play_RKRNBQNB_Ne3_Ne6_O_O_O()
    {
        $shuffle = ['R', 'K', 'R', 'N', 'B', 'Q', 'N', 'B'];

        $board = new Board($shuffle);

        $this->assertTrue($board->play('w', 'Ne3'));
        $this->assertTrue($board->play('b', 'Ne6'));
        $this->assertFalse($board->play('w', 'O-O-O'));

        $expected = [
            7 => [ 'r', 'k', 'r', '.', 'b', 'q', 'n', 'b' ],
            6 => [ 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p' ],
            5 => [ '.', '.', '.', '.', 'n', '.', '.', '.' ],
            4 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            3 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            2 => [ '.', '.', '.', '.', 'N', '.', '.', '.' ],
            1 => [ 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P' ],
            0 => [ 'R', 'K', 'R', '.', 'B', 'Q', 'N', 'B' ],
        ];

        $this->assertSame($expected, $board->toArray());
    }

    /**
     * @test
     */
    public function play_RKNBBQNR_Nd3_Nf6_Kc1()
    {
        $shuffle = ['R', 'K', 'N', 'B', 'B', 'Q', 'N', 'R'];

        $board = new Board($shuffle);

        $this->assertTrue($board->play('w', 'Nd3'));
        $this->assertTrue($board->play('b', 'Nf6'));
        $this->assertTrue($board->play('w', 'Kc1'));

        $expected = [
            7 => [ 'r', 'k', 'n', 'b', 'b', 'q', '.', 'r' ],
            6 => [ 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p' ],
            5 => [ '.', '.', '.', '.', '.', 'n', '.', '.' ],
            4 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            3 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            2 => [ '.', '.', '.', 'N', '.', '.', '.', '.' ],
            1 => [ 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P' ],
            0 => [ 'R', '.', 'K', 'B', 'B', 'Q', 'N', 'R' ],
        ];

        $this->assertSame($expected, $board->toArray());
    }

    /**
     * @test
     */
    public function play_RKNBBQNR_Nd3_Nf6_O_O()
    {
        $shuffle = ['R', 'K', 'N', 'B', 'B', 'Q', 'N', 'R'];

        $board = new Board($shuffle);

        $this->assertTrue($board->play('w', 'Nd3'));
        $this->assertTrue($board->play('b', 'Nf6'));
        $this->assertFalse($board->play('w', 'O-O'));

        $expected = [
            7 => [ 'r', 'k', 'n', 'b', 'b', 'q', '.', 'r' ],
            6 => [ 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p' ],
            5 => [ '.', '.', '.', '.', '.', 'n', '.', '.' ],
            4 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            3 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            2 => [ '.', '.', '.', 'N', '.', '.', '.', '.' ],
            1 => [ 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P' ],
            0 => [ 'R', 'K', '.', 'B', 'B', 'Q', 'N', 'R' ],
        ];

        $this->assertSame($expected, $board->toArray());
    }

    /**
     * @test
     */
    public function play_RKNBBQNR_Nd3_Nf6_O_O_O()
    {
        $shuffle = ['R', 'K', 'N', 'B', 'B', 'Q', 'N', 'R'];

        $board = new Board($shuffle);

        $this->assertTrue($board->play('w', 'Nd3'));
        $this->assertTrue($board->play('b', 'Nf6'));
        $this->assertFalse($board->play('w', 'O-O-O'));

        $expected = [
            7 => [ 'r', 'k', 'n', 'b', 'b', 'q', '.', 'r' ],
            6 => [ 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p' ],
            5 => [ '.', '.', '.', '.', '.', 'n', '.', '.' ],
            4 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            3 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            2 => [ '.', '.', '.', 'N', '.', '.', '.', '.' ],
            1 => [ 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P' ],
            0 => [ 'R', 'K', '.', 'B', 'B', 'Q', 'N', 'R' ],
        ];

        $this->assertSame($expected, $board->toArray());
    }

    /**
     * @test
     */
    public function play_NBQNRKBR_h3_h6_Bh2_Bh7_Kg1()
    {
        $shuffle = ['N', 'B', 'Q', 'N', 'R', 'K', 'B', 'R'];

        $board = new Board($shuffle);

        $this->assertTrue($board->play('w', 'h3'));
        $this->assertTrue($board->play('b', 'h6'));
        $this->assertTrue($board->play('w', 'Bh2'));
        $this->assertTrue($board->play('b', 'Bh7'));
        $this->assertTrue($board->play('w', 'Kg1'));

        $expected = [
            7 => [ 'n', 'b', 'q', 'n', 'r', 'k', '.', 'r' ],
            6 => [ 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'b' ],
            5 => [ '.', '.', '.', '.', '.', '.', '.', 'p' ],
            4 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            3 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            2 => [ '.', '.', '.', '.', '.', '.', '.', 'P' ],
            1 => [ 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'B' ],
            0 => [ 'N', 'B', 'Q', 'N', 'R', '.', 'K', 'R' ],
        ];

        $this->assertSame($expected, $board->toArray());
    }

    /**
     * @test
     */
    public function play_NBQNRKBR_h3_h6_Bh2_Bh7_Kg1_undo()
    {
        $shuffle = ['N', 'B', 'Q', 'N', 'R', 'K', 'B', 'R'];

        $board = new Board($shuffle);

        $this->assertTrue($board->play('w', 'h3'));
        $this->assertTrue($board->play('b', 'h6'));
        $this->assertTrue($board->play('w', 'Bh2'));
        $this->assertTrue($board->play('b', 'Bh7'));
        $this->assertTrue($board->play('w', 'Kg1'));

        $board->undo();

        $expected = [
            7 => [ 'n', 'b', 'q', 'n', 'r', 'k', '.', 'r' ],
            6 => [ 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'b' ],
            5 => [ '.', '.', '.', '.', '.', '.', '.', 'p' ],
            4 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            3 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            2 => [ '.', '.', '.', '.', '.', '.', '.', 'P' ],
            1 => [ 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'B' ],
            0 => [ 'N', 'B', 'Q', 'N', 'R', 'K', '.', 'R' ],
        ];

        $this->assertSame($expected, $board->toArray());
    }

    /**
     * @test
     */
    public function play_RNNQBKRB_O_O_undo()
    {
        $shuffle = ['R', 'N', 'N', 'Q', 'B', 'K', 'R', 'B'];

        $board = new Board($shuffle);

        $this->assertTrue($board->play('w', 'O-O'));

        $board->undo();

        $expected = [
            7 => [ 'r', 'n', 'n', 'q', 'b', 'k', 'r', 'b' ],
            6 => [ 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p' ],
            5 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            4 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            3 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            2 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            1 => [ 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P' ],
            0 => [ 'R', 'N', 'N', 'Q', 'B', 'K', 'R', 'B' ],
        ];

        $this->assertSame($expected, $board->toArray());
    }

    /**
     * @test
     */
    public function play_lan_RQKNBBRN_castle_long()
    {
        $shuffle = ['R', 'Q', 'K', 'N', 'B', 'B', 'R', 'N'];

        $board = new Board($shuffle);

        $board->playLan('w', 'd1e3');
        $board->playLan('b', 'd8e6');
        $board->playLan('w', 'f2f3');
        $board->playLan('b', 'f7f6');
        $board->playLan('w', 'e1f2');
        $board->playLan('b', 'g7g6');
        $board->playLan('w', 'g2g3');
        $board->playLan('b', 'e8f7');
        $board->playLan('w', 'f1g2');
        $board->playLan('b', 'f8g7');
        $board->playLan('w', 'c2c3');
        $board->playLan('b', 'c7c6');
        $board->playLan('w', 'b1c2');
        $board->playLan('b', 'b8c7');
        $board->playLan('w', 'c1c1');

        $expected = [
            7 => [ 'r', '.', 'k', '.', '.', '.', 'r', 'n' ],
            6 => [ 'p', 'p', 'q', 'p', 'p', 'b', 'b', 'p' ],
            5 => [ '.', '.', 'p', '.', 'n', 'p', 'p', '.' ],
            4 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            3 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            2 => [ '.', '.', 'P', '.', 'N', 'P', 'P', '.' ],
            1 => [ 'P', 'P', 'Q', 'P', 'P', 'B', 'B', 'P' ],
            0 => [ '.', '.', 'K', 'R', '.', '.', 'R', 'N' ],
        ];

        $this->assertSame($expected, $board->toArray());
    }

    /**
     * @test
     */
    public function play_RNQNBBKR_castle_short()
    {
        $shuffle = ['R', 'N', 'Q', 'N', 'B', 'B', 'K', 'R'];

        $board = new Board($shuffle);

        $board->play('w', 'g3');
        $board->play('b', 'g6');
        $board->play('w', 'Bg2');
        $board->play('b', 'Bg7');
        $board->play('w', 'O-O');

        $expected = [
            7 => [ 'r', 'n', 'q', 'n', 'b', '.', 'k', 'r' ],
            6 => [ 'p', 'p', 'p', 'p', 'p', 'p', 'b', 'p' ],
            5 => [ '.', '.', '.', '.', '.', '.', 'p', '.' ],
            4 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            3 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            2 => [ '.', '.', '.', '.', '.', '.', 'P', '.' ],
            1 => [ 'P', 'P', 'P', 'P', 'P', 'P', 'B', 'P' ],
            0 => [ 'R', 'N', 'Q', 'N', 'B', 'R', 'K', '.' ],
        ];

        $this->assertSame($expected, $board->toArray());
    }

    /**
     * @test
     */
    public function play_lan_RNQNBBKR_castle_short()
    {
        $expectedLegal = [
            'f1',
            'g1',
        ];

        $expectedArray = [
            7 => [ 'r', 'n', 'q', 'n', 'b', '.', 'k', 'r' ],
            6 => [ 'p', 'p', 'p', 'p', 'p', 'p', 'b', 'p' ],
            5 => [ '.', '.', '.', '.', '.', '.', 'p', '.' ],
            4 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            3 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            2 => [ '.', '.', '.', '.', '.', '.', 'P', '.' ],
            1 => [ 'P', 'P', 'P', 'P', 'P', 'P', 'B', 'P' ],
            0 => [ 'R', 'N', 'Q', 'N', 'B', 'R', 'K', '.' ],
        ];

        $shuffle = ['R', 'N', 'Q', 'N', 'B', 'B', 'K', 'R'];

        $board = new Board($shuffle);

        $board->playLan('w', 'g2g3');
        $board->playLan('b', 'g7g6');
        $board->playLan('w', 'f1g2');
        $board->playLan('b', 'f8g7');

        $this->assertSame($expectedLegal, $board->legal('g1'));

        $board->playLan('w', 'g1g1');

        $this->assertSame($expectedArray, $board->toArray());
    }
}
