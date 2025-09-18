<?php

namespace Chess\Tests\Unit\Variant\Classical;

use Chess\Play\SanPlay;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Capablanca\PGN\Square as CapablancaSquare;
use Chess\Variant\Classical\K;
use Chess\Variant\Classical\CastlingRule;
use Chess\Variant\Classical\PGN\Castle;
use Chess\Variant\Classical\PGN\Color;
use Chess\Variant\Classical\PGN\Piece;
use Chess\Variant\Classical\PGN\Square as ClassicalSquare;

class KTest extends AbstractUnitTestCase
{
    static private CastlingRule $castlingRule;

    static private ClassicalSquare $square;

    public static function setUpBeforeClass(): void
    {
        self::$castlingRule = new CastlingRule();

        self::$square = new ClassicalSquare();
    }

    /**
     * @test
     */
    public function w_CASTLE_LONG()
    {
        $rule = self::$castlingRule->rule[Color::W];

        $this->assertSame($rule[Castle::LONG]['free'], [ 'b1', 'c1', 'd1' ]);
        $this->assertSame($rule[Castle::LONG]['k'][0], 'e1');
        $this->assertSame($rule[Castle::LONG]['k'][1], 'c1');
        $this->assertSame($rule[Castle::LONG]['r'][0], 'a1');
        $this->assertSame($rule[Castle::LONG]['r'][1], 'd1');
    }

    /**
     * @test
     */
    public function b_CASTLE_LONG()
    {
        $rule = self::$castlingRule->rule[Color::B];

        $this->assertSame($rule[Castle::LONG]['free'], [ 'b8', 'c8', 'd8' ]);
        $this->assertSame($rule[Castle::LONG]['k'][0], 'e8');
        $this->assertSame($rule[Castle::LONG]['k'][1], 'c8');
        $this->assertSame($rule[Castle::LONG]['r'][0], 'a8');
        $this->assertSame($rule[Castle::LONG]['r'][1], 'd8');
    }

    /**
     * @test
     */
    public function w_CASTLE_SHORT()
    {
        $rule = self::$castlingRule->rule[Color::W];

        $this->assertSame($rule[Castle::SHORT]['free'], [ 'f1', 'g1' ]);
        $this->assertSame($rule[Castle::SHORT]['k'][0], 'e1');
        $this->assertSame($rule[Castle::SHORT]['k'][1], 'g1');
        $this->assertSame($rule[Castle::SHORT]['r'][0], 'h1');
        $this->assertSame($rule[Castle::SHORT]['r'][1], 'f1');
    }

    /**
     * @test
     */
    public function b_CASTLE_SHORT()
    {
        $rule = self::$castlingRule->rule[Color::B];

        $this->assertSame($rule[Castle::SHORT]['free'], [ 'f8', 'g8' ]);
        $this->assertSame($rule[Castle::SHORT]['k'][0], 'e8');
        $this->assertSame($rule[Castle::SHORT]['k'][1], 'g8');
        $this->assertSame($rule[Castle::SHORT]['r'][0], 'h8');
        $this->assertSame($rule[Castle::SHORT]['r'][1], 'f8');
    }

    /**
     * @test
     */
    public function flow_w_a2()
    {
        $king = new K('w', 'a2', self::$square);
        $flow = ['a3', 'a1', 'b2', 'b3', 'b1'];

        $this->assertEquals($flow, $king->flow);
    }

    /**
     * @test
     */
    public function flow_w_d5()
    {
        $king = new K('w', 'd5', self::$square);
        $flow = ['d6', 'd4', 'c5', 'e5', 'c6', 'e6', 'c4', 'e4'];

        $this->assertEquals($flow, $king->flow);
    }

    /**
     * @test
     */
    public function flow_w_f1()
    {
        $king = new K('w', 'f1', self::$square);
        $flow = ['f2', 'e1', 'g1', 'e2', 'g2'];

        $this->assertEquals($flow, $king->flow);
    }

    /**
     * @test
     */
    public function flow_b_f8()
    {
        $king = new K('b', 'f8', self::$square);
        $flow = ['f7', 'e8', 'g8', 'e7', 'g7'];

        $this->assertEquals($flow, $king->flow);
    }

    /**
     * @test
     */
    public function legal_sqs_A59()
    {
        $A59 = file_get_contents(self::DATA_FOLDER.'/opening/A59.pgn');

        $board = (new SanPlay($A59))->validate()->board;

        $king = $board->pieceBySq('f1');

        $expected = [ 'e1', 'e2', 'g2' ];

        $this->assertEqualsCanonicalizing($expected, $king->moveSqs());
    }

    /**
     * @test
     */
    public function capablanca_flow_w_f1()
    {
        $king = new K('w', 'f1', new CapablancaSquare());

        $flow = ['f2', 'e1', 'g1', 'e2', 'g2'];

        $this->assertEquals($flow, $king->flow);
    }
}
