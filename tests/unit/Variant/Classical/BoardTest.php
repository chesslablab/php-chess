<?php

namespace Chess\Tests\Unit\Variant\Classical;

use Chess\PgnParser;
use Chess\Computer\RandomMove;
use Chess\Play\SanPlay;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Classical\B;
use Chess\Variant\Classical\K;
use Chess\Variant\Classical\N;
use Chess\Variant\Classical\P;
use Chess\Variant\Classical\Q;
use Chess\Variant\Classical\R;
use Chess\Variant\Classical\Board;
use Chess\Variant\Classical\FenToBoardFactory;
use Chess\Variant\Classical\PGN\Color;
use Chess\Variant\Classical\PGN\Piece;
use Chess\Variant\Classical\PGN\Square;
use Chess\Variant\Classical\PGN\Move;

class BoardTest extends AbstractUnitTestCase
{
    static private Square $square;

    public static function setUpBeforeClass(): void
    {
        self::$square = new Square();
    }

    /**
     * @test
     */
    public function sample_classical()
    {
        $expected = [
            'total' => 82,
            'valid' => 82,
        ];

        $parser = new PgnParser(new Move(), self::DATA_FOLDER . "/sample/" . "classical.pgn");

        $parser->onValidation(function(array $tags, string $movetext) {
            $board = isset($tags['FEN']) 
                ? FenToBoardFactory::create($tags['FEN']) 
                : FenToBoardFactory::create();
            (new SanPlay($movetext, $board))->validate();
        });
        
        $parser->parse();

        $this->assertEquals($expected, $parser->getResult());
    }

    /**
     * @test
     */
    public function play_w_9()
    {
        $this->expectException(\Chess\Exception\UnknownNotationException::class);

        (new Board())->play('w', 9);
    }

    /**
     * @test
     */
    public function play_w_e9()
    {
        $this->expectException(\Chess\Exception\UnknownNotationException::class);

        (new Board())->play('w', 'e9');
    }

    /**
     * @test
     */
    public function play_w_Nw3()
    {
        $this->expectException(\Chess\Exception\UnknownNotationException::class);

        (new Board())->play('w', 'Nw3');
    }

    /**
     * @test
     */
    public function castling_ability_in_C67()
    {
        $C67 = file_get_contents(self::DATA_FOLDER.'/opening/C67.pgn');

        $board = (new SanPlay($C67))->validate()->board;

        $expected = 'kq';

        $this->assertSame($expected, $board->castlingAbility);
    }

    /**
     * @test
     */
    public function history_in_C60()
    {
        $C60 = file_get_contents(self::DATA_FOLDER.'/opening/C60.pgn');
        $C60 = str_replace("\n", "", $C60);

        $board = (new SanPlay($C60))->validate()->board;

        $expected = [
            [
                'pgn' => 'e4',
                'color' => 'w',
                'id' => 'P',
                'from' => 'e2',
                'to' => 'e4',
                'fen' => 'rnbqkbnr/pppppppp/8/8/4P3/8/PPPP1PPP/RNBQKBNR b KQkq e3 0 1',
            ],
            [
                'pgn' => 'e5',
                'color' => 'b',
                'id' => 'P',
                'from' => 'e7',
                'to' => 'e5',
                'fen' => 'rnbqkbnr/pppp1ppp/8/4p3/4P3/8/PPPP1PPP/RNBQKBNR w KQkq e6 0 2',
            ],
            [
                'pgn' => 'Nf3',
                'color' => 'w',
                'id' => 'N',
                'from' => 'g1',
                'to' => 'f3',
                'fen' => 'rnbqkbnr/pppp1ppp/8/4p3/4P3/5N2/PPPP1PPP/RNBQKB1R b KQkq - 1 2',
            ],
            [
                'pgn' => 'Nc6',
                'color' => 'b',
                'id' => 'N',
                'from' => 'b8',
                'to' => 'c6',
                'fen' => 'r1bqkbnr/pppp1ppp/2n5/4p3/4P3/5N2/PPPP1PPP/RNBQKB1R w KQkq - 2 3',
            ],
            [
                'pgn' => 'Bb5',
                'color' => 'w',
                'id' => 'B',
                'from' => 'f1',
                'to' => 'b5',
                'fen' => 'r1bqkbnr/pppp1ppp/2n5/1B2p3/4P3/5N2/PPPP1PPP/RNBQK2R b KQkq - 3 3',
            ],
            [
                'pgn' => 'Be7',
                'color' => 'b',
                'id' => 'B',
                'from' => 'f8',
                'to' => 'e7',
                'fen' => 'r1bqk1nr/ppppbppp/2n5/1B2p3/4P3/5N2/PPPP1PPP/RNBQK2R w KQkq - 4 4',
            ],
        ];

        $this->assertEquals($expected, $board->history);
    }

    /**
     * @test
     */
    public function history_in_a4_h5_Ra3_Rh6()
    {
        $board = new Board();

        $board->play('w', 'a4');
        $board->play('b', 'h5');
        $board->play('w', 'Ra3');
        $board->play('b', 'Rh6');

        $expected = [
            [
                'pgn' => 'a4',
                'color' => 'w',
                'id' => 'P',
                'from' => 'a2',
                'to' => 'a4',
                'fen' => 'rnbqkbnr/pppppppp/8/8/P7/8/1PPPPPPP/RNBQKBNR b KQkq a3 0 1',
            ],
            [
                'pgn' => 'h5',
                'color' => 'b',
                'id' => 'P',
                'from' => 'h7',
                'to' => 'h5',
                'fen' => 'rnbqkbnr/ppppppp1/8/7p/P7/8/1PPPPPPP/RNBQKBNR w KQkq h6 0 2',
            ],
            [
                'pgn' => 'Ra3',
                'color' => 'w',
                'id' => 'R',
                'from' => 'a1',
                'to' => 'a3',
                'fen' => 'rnbqkbnr/ppppppp1/8/7p/P7/R7/1PPPPPPP/1NBQKBNR b Kkq - 1 2',
            ],
            [
                'pgn' => 'Rh6',
                'color' => 'b',
                'id' => 'R',
                'from' => 'h8',
                'to' => 'h6',
                'fen' => 'rnbqkbn1/ppppppp1/7r/7p/P7/R7/1PPPPPPP/1NBQKBNR w Kq - 2 3',
            ],
        ];

        $this->assertEquals($expected, $board->history);
    }

    /**
     * @test
     */
    public function pieces_in_A59()
    {
        $A59 = file_get_contents(self::DATA_FOLDER.'/opening/A59.pgn');

        $board = (new SanPlay($A59))->validate()->board;

        $this->assertSame(14, count($board->pieces(Color::W)));
        $this->assertSame(13, count($board->pieces(Color::B)));
    }

    /**
     * @test
     */
    public function to_array_e4_e5()
    {
        $board = new Board();
        $board->play('w', 'e4');
        $board->play('b', 'e5');

        $expected = [
            7 => [ 'r', 'n', 'b', 'q', 'k', 'b', 'n', 'r' ],
            6 => [ 'p', 'p', 'p', 'p', '.', 'p', 'p', 'p' ],
            5 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            4 => [ '.', '.', '.', '.', 'p', '.', '.', '.' ],
            3 => [ '.', '.', '.', '.', 'P', '.', '.', '.' ],
            2 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            1 => [ 'P', 'P', 'P', 'P', '.', 'P', 'P', 'P' ],
            0 => [ 'R', 'N', 'B', 'Q', 'K', 'B', 'N', 'R' ],
        ];

        $this->assertSame($expected, $board->toArray());
    }

    /**
     * @test
     */
    public function to_array_A59()
    {
        $A59 = file_get_contents(self::DATA_FOLDER.'/opening/A59.pgn');

        $board = (new SanPlay($A59))->validate()->board;

        $expected = [
            7 => [ 'r', 'n', '.', 'q', 'k', 'b', '.', 'r' ],
            6 => [ '.', '.', '.', '.', 'p', 'p', '.', 'p' ],
            5 => [ '.', '.', '.', 'p', '.', 'n', 'p', '.' ],
            4 => [ '.', '.', 'p', 'P', '.', '.', '.', '.' ],
            3 => [ '.', '.', '.', '.', 'P', '.', '.', '.' ],
            2 => [ '.', '.', 'N', '.', '.', '.', 'P', '.' ],
            1 => [ 'P', 'P', '.', '.', '.', 'P', '.', 'P' ],
            0 => [ 'R', '.', 'B', 'Q', '.', 'K', 'N', 'R' ],
        ];

        $this->assertSame($expected, $board->toArray());
    }

    /**
     * @test
     */
    public function sq_count_start()
    {
        $board = new Board();

        $sqCount = $board->sqCount();

        $expected = [
            'a3', 'a4', 'a5', 'a6',
            'b3', 'b4', 'b5', 'b6',
            'c3', 'c4', 'c5', 'c6',
            'd3', 'd4', 'd5', 'd6',
            'e3', 'e4', 'e5', 'e6',
            'f3', 'f4', 'f5', 'f6',
            'g3', 'g4', 'g5', 'g6',
            'h3', 'h4', 'h5', 'h6',
        ];

        $this->assertEqualsCanonicalizing($expected, $sqCount['free']);
    }

    /**
     * @test
     */
    public function init_pieces_and_pick_a_nonexistent_piece()
    {
        $pieces = [
            new P('w', 'a2', self::$square),
            new P('w', 'a3', self::$square),
            new P('w', 'c3', self::$square),
            new R('w', 'e6', self::$square),
            new K('w', 'g3', self::$square),
            new P('b', 'a6', self::$square),
            new P('b', 'b5', self::$square),
            new P('b', 'c4', self::$square),
            new N('b', 'd3', self::$square),
            new R('b', 'f5', self::$square),
            new K('b', 'g5', self::$square),
            new P('b', 'h7', self::$square)
        ];

        $castlingAbility = '-';

        $board = new Board($pieces, $castlingAbility);

        $this->assertFalse($board->play('w', 'f4'));
    }

    /**
     * @test
     */
    public function play_b_Qg5()
    {
        $board = new Board();

        $this->assertFalse($board->play('b', 'Qg5'));
    }

    /**
     * @test
     */
    public function play_w_Ra6()
    {
        $board = new Board();

        $this->assertFalse($board->play('w', 'Ra6'));
    }

    /**
     * @test
     */
    public function play_b_Rxa6()
    {
        $board = new Board();

        $this->assertFalse($board->play('b', 'Rxa6'));
    }

    /**
     * @test
     */
    public function play_w_CASTLE_SHORT()
    {
        $board = new Board();

        $this->assertFalse($board->play('w', 'O-O'));
    }

    /**
     * @test
     */
    public function play_a_falsy_game()
    {
        $board = new Board();

        $this->assertFalse($board->play('w', 'O-O'));
        $this->assertFalse($board->play('w', 'O-O-O'));
        $this->assertFalse($board->play('w', 'e5'));

        $this->assertTrue($board->play('w', 'e4'));
        $this->assertTrue($board->play('b', 'e5'));

        $this->assertTrue($board->play('w', 'Nf3'));
        $this->assertTrue($board->play('b', 'Nc6'));

        $this->assertFalse($board->play('w', 'Ra2'));
        $this->assertFalse($board->play('w', 'Ra3'));
        $this->assertFalse($board->play('w', 'Ra4'));
        $this->assertFalse($board->play('w', 'Ra5'));
        $this->assertFalse($board->play('w', 'Ra6'));
        $this->assertFalse($board->play('w', 'Ra7'));
        $this->assertFalse($board->play('w', 'Ra8'));
    }

    /**
     * @test
     */
    public function init_pieces_and_play_w_Kf4()
    {
        $pieces = [
            new P('w', 'a2', self::$square),
            new P('w', 'a3', self::$square),
            new P('w', 'c3', self::$square),
            new R('w', 'e6', self::$square),
            new K('w', 'g3', self::$square),
            new P('b', 'a6', self::$square),
            new P('b', 'b5', self::$square),
            new P('b', 'c4', self::$square),
            new N('b', 'd3', self::$square),
            new R('b', 'f5', self::$square),
            new K('b', 'g5', self::$square),
            new P('b', 'h7', self::$square)
        ];

        $castlingAbility = '-';

        $board = new Board($pieces, $castlingAbility);

        $this->assertFalse($board->play('w', 'Kf4'));
    }

    /**
     * @test
     */
    public function init_pieces_and_play_w_Kf4_in_check()
    {
        $pieces = [
            new P('w', 'a2', self::$square),
            new P('w', 'a3', self::$square),
            new P('w', 'c3', self::$square),
            new R('w', 'e6', self::$square),
            new K('w', 'f3', self::$square), // in check!
            new P('b', 'a6', self::$square),
            new P('b', 'b5', self::$square),
            new P('b', 'c4', self::$square),
            new N('b', 'd3', self::$square),
            new R('b', 'f5', self::$square),
            new K('b', 'g5', self::$square),
            new P('b', 'h7', self::$square)
        ];

        $castlingAbility = '-';

        $board = new Board($pieces, $castlingAbility);

        $this->assertFalse($board->play('w', 'Kf4'));
    }

    /**
     * @test
     */
    public function init_pieces_and_play_w_Kf2_in_check()
    {
        $pieces = [
            new P('w', 'a2', self::$square),
            new P('w', 'a3', self::$square),
            new P('w', 'c3', self::$square),
            new R('w', 'e6', self::$square),
            new K('w', 'f3', self::$square), // in check!
            new P('b', 'a6', self::$square),
            new P('b', 'b5', self::$square),
            new P('b', 'c4', self::$square),
            new N('b', 'd3', self::$square),
            new R('b', 'f5', self::$square),
            new K('b', 'g5', self::$square),
            new P('b', 'h7', self::$square)
        ];

        $castlingAbility = '-';

        $board = new Board($pieces, $castlingAbility);

        $this->assertFalse($board->play('w', 'Kf2'));
    }

    /**
     * @test
     */
    public function init_pieces_and_play_w_Re7_in_check()
    {
        $pieces = [
            new P('w', 'a2', self::$square),
            new P('w', 'a3', self::$square),
            new P('w', 'c3', self::$square),
            new R('w', 'e6', self::$square),
            new K('w', 'f3', self::$square), // in check!
            new P('b', 'a6', self::$square),
            new P('b', 'b5', self::$square),
            new P('b', 'c4', self::$square),
            new N('b', 'd3', self::$square),
            new R('b', 'f5', self::$square),
            new K('b', 'g5', self::$square),
            new P('b', 'h7', self::$square)
        ];

        $castlingAbility = '-';

        $board = new Board($pieces, $castlingAbility);

        $this->assertFalse($board->play('w', 'Re7'));
    }

    /**
     * @test
     */
    public function init_pieces_and_play_w_a4_in_check()
    {
        $pieces = [
            new P('w', 'a2', self::$square),
            new P('w', 'a3', self::$square),
            new P('w', 'c3', self::$square),
            new R('w', 'e6', self::$square),
            new K('w', 'f3', self::$square), // in check!
            new P('b', 'a6', self::$square),
            new P('b', 'b5', self::$square),
            new P('b', 'c4', self::$square),
            new N('b', 'd3', self::$square),
            new R('b', 'f5', self::$square),
            new K('b', 'g5', self::$square),
            new P('b', 'h7', self::$square)
        ];

        $castlingAbility = '-';

        $board = new Board($pieces, $castlingAbility);

        $this->assertFalse($board->play('w', 'a4'));
    }

    /**
     * @test
     */
    public function init_pieces_and_play_w_Kxf2()
    {
        $pieces = [
            new P('w', 'a2', self::$square),
            new P('w', 'a3', self::$square),
            new P('w', 'c3', self::$square),
            new R('w', 'e6', self::$square),
            new K('w', 'g3', self::$square),
            new P('b', 'a6', self::$square),
            new P('b', 'b5', self::$square),
            new P('b', 'c4', self::$square),
            new N('b', 'd3', self::$square),
            new R('b', 'f2', self::$square), // rook defended by knight
            new K('b', 'g5', self::$square),
            new P('b', 'h7', self::$square)
        ];

        $castlingAbility = '-';

        $board = new Board($pieces, $castlingAbility);

        $this->assertFalse($board->play('w', 'Kxf2'));
    }

    /**
     * @test
     */
    public function init_pieces_and_play_w_CASTLE_SHORT()
    {
        $board = new Board();

        $board->play('w', 'e4');
        $board->play('b', 'c5');
        $board->play('w', 'Nf3');
        $board->play('b', 'Nc6');

        $this->assertFalse($board->play('w', 'O-O'));
    }

    /**
     * @test
     */
    public function init_pieces_and_play_w_CASTLE_LONG()
    {
        $board = new Board();

        $board->play('w', 'e4');
        $board->play('b', 'c5');
        $board->play('w', 'Nf3');
        $board->play('b', 'Nc6');
        $board->play('w', 'Bb5');
        $board->play('b', 'Nf6');

        $this->assertFalse($board->play('w', 'O-O-O'));
    }

    /**
     * @test
     */
    public function init_pieces_and_play_w_CASTLE_SHORT_with_threats_on_f1()
    {
        $pieces = [
            new P('w', 'a2', self::$square),
            new P('w', 'd4', self::$square),
            new P('w', 'e4', self::$square),
            new P('w', 'f2', self::$square),
            new P('w', 'g2', self::$square),
            new P('w', 'h2', self::$square),
            new R('w', 'a1', self::$square),
            new K('w', 'e1', self::$square),
            new R('w', 'h1', self::$square),
            new B('b', 'a6', self::$square), // bishop threatening f1
            new K('b', 'e8', self::$square),
            new B('b', 'f8', self::$square),
            new N('b', 'g8', self::$square),
            new R('b', 'h8', self::$square),
            new P('b', 'f7', self::$square),
            new P('b', 'g7', self::$square),
            new P('b', 'h7', self::$square)
        ];

        $castlingAbility = 'KQk';

        $board = new Board($pieces, $castlingAbility);

        $this->assertFalse($board->play('w', 'O-O'));
    }

    /**
     * @test
     */
    public function init_pieces_and_play_w_CASTLE_SHORT_with_threats_on_f1_g1()
    {
        $pieces = [
            new P('w', 'a2', self::$square),
            new P('w', 'd5', self::$square),
            new P('w', 'e4', self::$square),
            new P('w', 'f3', self::$square),
            new P('w', 'g2', self::$square),
            new P('w', 'h2', self::$square),
            new R('w', 'a1', self::$square),
            new K('w', 'e1', self::$square),
            new R('w', 'h1', self::$square),
            new B('b', 'a6', self::$square), // bishop threatening f1
            new K('b', 'e8', self::$square),
            new B('b', 'c5', self::$square), // bishop threatening g1
            new N('b', 'g8', self::$square),
            new R('b', 'h8', self::$square),
            new P('b', 'f7', self::$square),
            new P('b', 'g7', self::$square),
            new P('b', 'h7', self::$square)
        ];

        $castlingAbility = 'KQk';

        $board = new Board($pieces, $castlingAbility);

        $this->assertFalse($board->play('w', 'O-O'));
    }

    /**
     * @test
     */
    public function init_pieces_and_play_w_CASTLE_SHORT_with_threats_on_g1()
    {
        $pieces = [
            new P('w', 'a2', self::$square),
            new P('w', 'd5', self::$square),
            new P('w', 'e4', self::$square),
            new P('w', 'f3', self::$square),
            new P('w', 'g2', self::$square),
            new P('w', 'h2', self::$square),
            new R('w', 'a1', self::$square),
            new K('w', 'e1', self::$square),
            new R('w', 'h1', self::$square),
            new K('b', 'e8', self::$square),
            new B('b', 'c5', self::$square), // bishop threatening g1
            new N('b', 'g8', self::$square),
            new R('b', 'h8', self::$square),
            new P('b', 'f7', self::$square),
            new P('b', 'g7', self::$square),
            new P('b', 'h7', self::$square)
        ];

        $castlingAbility = 'KQk';

        $board = new Board($pieces, $castlingAbility);

        $this->assertFalse($board->play('w', 'O-O'));
    }

    /**
     * @test
     */
    public function init_pieces_and_play_w_CASTLE_LONG_with_threats_on_c1()
    {
        $pieces = [
            new P('w', 'a2', self::$square),
            new P('w', 'd5', self::$square),
            new P('w', 'e4', self::$square),
            new P('w', 'f3', self::$square),
            new P('w', 'g2', self::$square),
            new P('w', 'h2', self::$square),
            new R('w', 'a1', self::$square),
            new K('w', 'e1', self::$square),
            new R('w', 'h1', self::$square),
            new K('b', 'e8', self::$square),
            new B('b', 'f4', self::$square), // bishop threatening c1
            new N('b', 'g8', self::$square),
            new R('b', 'h8', self::$square),
            new P('b', 'f7', self::$square),
            new P('b', 'g7', self::$square),
            new P('b', 'h7', self::$square)
        ];

        $castlingAbility = 'KQk';

        $board = new Board($pieces, $castlingAbility);

        $this->assertFalse($board->play('w', 'O-O-O'));
    }

    /**
     * @test
     */
    public function init_pieces_and_castle_with_threats_on_d1_f1()
    {
        $pieces = [
            new P('w', 'a2', self::$square),
            new P('w', 'd5', self::$square),
            new P('w', 'e4', self::$square),
            new P('w', 'f3', self::$square),
            new P('w', 'g2', self::$square),
            new P('w', 'h2', self::$square),
            new R('w', 'a1', self::$square),
            new K('w', 'e1', self::$square),
            new R('w', 'h1', self::$square),
            new K('b', 'e8', self::$square),
            new B('b', 'f8', self::$square),
            new N('b', 'e3', self::$square), // knight threatening d1 and f1
            new R('b', 'h8', self::$square),
            new P('b', 'f7', self::$square),
            new P('b', 'g7', self::$square),
            new P('b', 'h7', self::$square)
        ];

        $castlingAbility = 'KQk';

        $board = new Board($pieces, $castlingAbility);

        $this->assertFalse($board->play('w', 'O-O'));
        $this->assertFalse($board->play('w', 'O-O-O'));
    }

    /**
     * @test
     */
    public function init_pieces_and_castle_with_threats_on_b1_f1()
    {
        $pieces = [
            new P('w', 'a2', self::$square),
            new P('w', 'd5', self::$square),
            new P('w', 'e4', self::$square),
            new P('w', 'f3', self::$square),
            new P('w', 'g2', self::$square),
            new P('w', 'h2', self::$square),
            new R('w', 'a1', self::$square),
            new K('w', 'e1', self::$square),
            new R('w', 'h1', self::$square),
            new K('b', 'e8', self::$square),
            new B('b', 'f8', self::$square),
            new N('b', 'd2', self::$square), // knight threatening b1 and f1
            new R('b', 'h8', self::$square),
            new P('b', 'f7', self::$square),
            new P('b', 'g7', self::$square),
            new P('b', 'h7', self::$square)
        ];

        $castlingAbility = 'KQk';

        $board = new Board($pieces, $castlingAbility);

        $this->assertFalse($board->play('w', 'O-O'));
        $this->assertTrue($board->play('w', 'O-O-O'));
    }

    /**
     * @test
     */
    public function init_pieces_and_play_w_CASTLE_LONG_with_threats_on_b1_d1()
    {
        $pieces = [
            new P('w', 'a2', self::$square),
            new P('w', 'd5', self::$square),
            new P('w', 'e4', self::$square),
            new P('w', 'f3', self::$square),
            new P('w', 'g2', self::$square),
            new P('w', 'h2', self::$square),
            new R('w', 'a1', self::$square),
            new K('w', 'e1', self::$square),
            new R('w', 'h1', self::$square),
            new K('b', 'e8', self::$square),
            new B('b', 'f8', self::$square),
            new N('b', 'c3', self::$square), // knight threatening b1 and d1
            new R('b', 'h8', self::$square),
            new P('b', 'f7', self::$square),
            new P('b', 'g7', self::$square),
            new P('b', 'h7', self::$square)
        ];

        $castlingAbility = 'KQk';

        $board = new Board($pieces, $castlingAbility);

        $this->assertFalse($board->play('w', 'O-O-O'));
    }

    /**
     * @test
     */
    public function init_pieces_and_play_w_CASTLE_SHORT_after_Kf1()
    {
        $pieces = [
            new P('w', 'a2', self::$square),
            new P('w', 'd5', self::$square),
            new P('w', 'e4', self::$square),
            new P('w', 'f3', self::$square),
            new P('w', 'g2', self::$square),
            new P('w', 'h2', self::$square),
            new R('w', 'a1', self::$square),
            new K('w', 'e1', self::$square),
            new R('w', 'h1', self::$square),
            new K('b', 'e8', self::$square),
            new B('b', 'f8', self::$square),
            new N('b', 'g8', self::$square),
            new R('b', 'h8', self::$square),
            new P('b', 'f7', self::$square),
            new P('b', 'g7', self::$square),
            new P('b', 'h7', self::$square)
        ];

        $castlingAbility = 'KQk';

        $board = new Board($pieces, $castlingAbility);

        $this->assertTrue($board->play('w', 'Kf1'));
        $this->assertTrue($board->play('b', 'Nf6'));
        $this->assertTrue($board->play('w', 'Ke1'));
        $this->assertTrue($board->play('b', 'Nd7'));
        $this->assertFalse($board->play('w', 'O-O'));
    }

    /**
     * @test
     */
    public function init_pieces_and_play_w_CASTLE_SHORT_after_Rg1()
    {
        $pieces = [
            new P('w', 'a2', self::$square),
            new P('w', 'd5', self::$square),
            new P('w', 'e4', self::$square),
            new P('w', 'f3', self::$square),
            new P('w', 'g2', self::$square),
            new P('w', 'h2', self::$square),
            new R('w', 'a1', self::$square),
            new K('w', 'e1', self::$square),
            new R('w', 'h1', self::$square),
            new K('b', 'e8', self::$square),
            new B('b', 'f8', self::$square),
            new N('b', 'g8', self::$square),
            new R('b', 'h8', self::$square),
            new P('b', 'f7', self::$square),
            new P('b', 'g7', self::$square),
            new P('b', 'h7', self::$square)
        ];

        $castlingAbility = 'KQk';

        $board = new Board($pieces, $castlingAbility);

        $this->assertTrue($board->play('w', 'Rg1'));
        $this->assertTrue($board->play('b', 'Nf6'));
        $this->assertTrue($board->play('w', 'Rh1'));
        $this->assertTrue($board->play('b', 'Nd7'));
        $this->assertFalse($board->play('w', 'O-O'));
    }

    /**
     * @test
     */
    public function init_pieces_and_play_b_CASTLE_SHORT_with_threats()
    {
        $pieces = [
            new P('w', 'a2', self::$square),
            new P('w', 'c2', self::$square),
            new P('w', 'c3', self::$square),
            new P('w', 'd4', self::$square),
            new P('w', 'f2', self::$square),
            new P('w', 'g2', self::$square),
            new P('w', 'h2', self::$square),
            new R('w', 'a1', self::$square),
            new K('w', 'e1', self::$square),
            new N('w', 'g1', self::$square),
            new R('w', 'h1', self::$square),
            new B('w', 'a3', self::$square),
            new B('w', 'd3', self::$square),
            new P('b', 'a7', self::$square),
            new P('b', 'b6', self::$square),
            new P('b', 'c7', self::$square),
            new P('b', 'e6', self::$square),
            new P('b', 'g7', self::$square),
            new P('b', 'h6', self::$square),
            new R('b', 'a8', self::$square),
            new B('b', 'c8', self::$square),
            new Q('b', 'd8', self::$square),
            new K('b', 'e8', self::$square),
            new R('b', 'h8', self::$square),
            new N('b', 'd7', self::$square),
            new N('b', 'f6', self::$square)
        ];

        $castlingAbility = 'KQk';

        $board = new Board($pieces, $castlingAbility);

        $this->assertTrue($board->play('w', 'Nf3'));
        $this->assertFalse($board->play('b', 'O-O'));
    }

    /**
     * @test
     */
    public function init_pieces_and_play_lan_w_h8_q()
    {
        $pieces = [
            new P('w', 'g2', self::$square),
            new P('w', 'h7', self::$square),
            new K('w', 'e1', self::$square),
            new R('w', 'h1', self::$square),
            new P('b', 'c7', self::$square),
            new P('b', 'd7', self::$square),
            new P('b', 'e7', self::$square),
            new B('b', 'd6', self::$square),
            new K('b', 'e8', self::$square)
        ];

        $castlingAbility = 'K';

        $board = new Board($pieces, $castlingAbility);

        $this->assertTrue($board->playLan('w', 'h7h8q'));
    }

    /**
     * @test
     */
    public function init_pieces_and_play_lan_w_h8_n()
    {
        $pieces = [
            new P('w', 'g2', self::$square),
            new P('w', 'h7', self::$square),
            new K('w', 'e1', self::$square),
            new R('w', 'h1', self::$square),
            new P('b', 'c7', self::$square),
            new P('b', 'd7', self::$square),
            new P('b', 'e7', self::$square),
            new B('b', 'd6', self::$square),
            new K('b', 'e8', self::$square)
        ];

        $castlingAbility = 'K';

        $board = new Board($pieces, $castlingAbility);

        $board->playLan('w', 'h7h8n');

        $this->assertEquals('N', $board->pieceBySq('h8')->id);
    }

    /**
     * @test
     */
    public function init_pieces_and_play_w_h8_r()
    {
        $pieces = [
            new P('w', 'g2', self::$square),
            new P('w', 'h7', self::$square),
            new K('w', 'e1', self::$square),
            new R('w', 'h1', self::$square),
            new P('b', 'c7', self::$square),
            new P('b', 'd7', self::$square),
            new P('b', 'e7', self::$square),
            new B('b', 'd6', self::$square),
            new K('b', 'e8', self::$square)
        ];

        $castlingAbility = 'K';

        $board = new Board($pieces, $castlingAbility);

        $this->assertTrue($board->play('w', 'h8=R'));
    }

    /**
     * @test
     */
    public function init_pieces_and_play_lan_w_h8_r()
    {
        $pieces = [
            new P('w', 'g2', self::$square),
            new P('w', 'h7', self::$square),
            new K('w', 'e1', self::$square),
            new R('w', 'h1', self::$square),
            new P('b', 'c7', self::$square),
            new P('b', 'd7', self::$square),
            new P('b', 'e7', self::$square),
            new B('b', 'd6', self::$square),
            new K('b', 'e8', self::$square)
        ];

        $castlingAbility = 'K';

        $board = new Board($pieces, $castlingAbility);

        $board->playLan('w', 'h7h8r');

        $this->assertEquals('R', $board->pieceBySq('h8')->id);
    }

    /**
     * @test
     */
    public function init_pieces_and_play_w_h8_b()
    {
        $pieces = [
            new P('w', 'g2', self::$square),
            new P('w', 'h7', self::$square),
            new K('w', 'e1', self::$square),
            new R('w', 'h1', self::$square),
            new P('b', 'c7', self::$square),
            new P('b', 'd7', self::$square),
            new P('b', 'e7', self::$square),
            new B('b', 'd6', self::$square),
            new K('b', 'e8', self::$square)
        ];

        $castlingAbility = 'K';

        $board = new Board($pieces, $castlingAbility);

        $this->assertTrue($board->play('w', 'h8=B'));
    }

    /**
     * @test
     */
    public function init_pieces_and_play_lan_w_h8_b()
    {
        $pieces = [
            new P('w', 'g2', self::$square),
            new P('w', 'h7', self::$square),
            new K('w', 'e1', self::$square),
            new R('w', 'h1', self::$square),
            new P('b', 'c7', self::$square),
            new P('b', 'd7', self::$square),
            new P('b', 'e7', self::$square),
            new B('b', 'd6', self::$square),
            new K('b', 'e8', self::$square)
        ];

        $castlingAbility = 'K';

        $board = new Board($pieces, $castlingAbility);

        $board->playLan('w', 'h7h8b');

        $this->assertEquals('B', $board->pieceBySq('h8')->id);
    }

    /**
     * @test
     */
    public function init_pieces_and_play_lan_w_h8_z()
    {
        $this->expectException(\Chess\Exception\UnknownNotationException::class);

        $pieces = [
            new P('w', 'g2', self::$square),
            new P('w', 'h7', self::$square),
            new K('w', 'e1', self::$square),
            new R('w', 'h1', self::$square),
            new P('b', 'c7', self::$square),
            new P('b', 'd7', self::$square),
            new P('b', 'e7', self::$square),
            new B('b', 'd6', self::$square),
            new K('b', 'e8', self::$square)
        ];

        $castlingAbility = 'K';

        $board = new Board($pieces, $castlingAbility);

        $board->playLan('w', 'h7h8z');
    }

    /**
     * @test
     */
    public function init_pieces_and_checkmate_w_Qd7()
    {
        $pieces = [
            new P('w', 'd5', self::$square),
            new Q('w', 'f5', self::$square),
            new K('w', 'g2', self::$square),
            new P('w', 'h2', self::$square),
            new R('w', 'h8', self::$square),
            new K('b', 'e7', self::$square),
            new P('b', 'f7', self::$square),
            new P('b', 'g7', self::$square),
            new P('b', 'h7', self::$square)
        ];

        $castlingAbility = '-';

        $board = new Board($pieces, $castlingAbility);

        $this->assertTrue($board->play('w', 'd6+'));
        $this->assertTrue($board->isCheck());
        $this->assertFalse($board->isMate());
        $this->assertFalse($board->play('b', 'Kd7'));
        $this->assertTrue($board->isCheck());
        $this->assertFalse($board->isMate());
        $this->assertFalse($board->play('b', 'Ke6'));
        $this->assertTrue($board->isCheck());
        $this->assertFalse($board->isMate());
        $this->assertTrue($board->play('b', 'Kxd6'));
        $this->assertFalse($board->isCheck());
        $this->assertFalse($board->isMate());
        $this->assertTrue($board->play('w', 'Re8'));
        $this->assertFalse($board->isCheck());
        $this->assertFalse($board->isMate());
        $this->assertTrue($board->play('b', 'Kc7'));
        $this->assertFalse($board->isCheck());
        $this->assertFalse($board->isMate());
        $this->assertTrue($board->play('w', 'Re7+'));
        $this->assertTrue($board->isCheck());
        $this->assertFalse($board->isMate());
        $this->assertTrue($board->play('b', 'Kd8'));
        $this->assertFalse($board->isCheck());
        $this->assertFalse($board->isMate());
        $this->assertTrue($board->play('w', 'Qd7#'));
        $this->assertTrue($board->isCheck());
        $this->assertTrue($board->isMate());
    }

    /**
     * @test
     */
    public function init_pieces_stalemate_king_and_queen_vs_king()
    {
        $pieces = [
            new K('b', 'h1', self::$square),
            new K('w', 'a8', self::$square),
            new Q('w', 'f2', self::$square),
        ];

        $castlingAbility = '-';

        $board = new Board($pieces, $castlingAbility);
        $board->turn = 'b';

        $this->assertFalse($board->isMate());
        $this->assertTrue($board->isStalemate());
    }

    /**
     * @test
     */
    public function init_pieces_stalemate_king_and_pawn_vs_king()
    {
        $pieces = [
            new K('w', 'f6', self::$square),
            new P('w', 'f7', self::$square),
            new K('b', 'f8', self::$square),
        ];

        $castlingAbility = '-';

        $board = new Board($pieces, $castlingAbility);
        $board->turn = 'b';

        $this->assertFalse($board->isMate());
        $this->assertTrue($board->isStalemate());
    }

    /**
     * @test
     */
    public function init_pieces_stalemate_king_and_rook_vs_king_and_bishop()
    {
        $pieces = [
            new K('w', 'b6', self::$square),
            new R('w', 'h8', self::$square),
            new K('b', 'a8', self::$square),
            new B('b', 'b8', self::$square),
        ];

        $castlingAbility = '-';

        $board = new Board($pieces, $castlingAbility);
        $board->turn = 'b';

        $this->assertFalse($board->isMate());
        $this->assertTrue($board->isStalemate());
    }

    /**
     * @test
     */
    public function init_pieces_stalemate_endgame()
    {
        $pieces = [
            new K('w', 'g1', self::$square),
            new Q('w', 'd1', self::$square),
            new R('w', 'a5', self::$square),
            new R('w', 'b7', self::$square),
            new P('w', 'f6', self::$square),
            new P('w', 'g5', self::$square),
            new K('b', 'e6', self::$square),
        ];

        $castlingAbility = '-';

        $board = new Board($pieces, $castlingAbility);
        $board->turn = 'b';

        $this->assertFalse($board->isMate());
        $this->assertTrue($board->isStalemate());
    }

    /**
     * @test
     */
    public function undo_e4_e5()
    {
        $board = new Board();

        $board->play('w', 'e4');
        $board->play('b', 'e5');

        $board->undo();

        $expected = 'rnbqkbnr/pppppppp/8/8/4P3/8/PPPP1PPP/RNBQKBNR b KQkq e3 0 1';

        $this->assertSame($expected, $board->toFen());
    }

    /**
     * @test
     */
    public function undo_e4_b6_Nf3_Bb7_Bc4_Nc6_O_O()
    {
        $board = new Board();

        $board->play('w', 'e4');
        $board->play('b', 'b6');
        $board->play('w', 'Nf3');
        $board->play('b', 'Bb7');
        $board->play('w', 'Bc4');
        $board->play('b', 'Nc6');
        $board->play('w', 'O-O');

        $board->undo();

        $expected = 'r2qkbnr/pbpppppp/1pn5/8/2B1P3/5N2/PPPP1PPP/RNBQK2R w KQkq - 4 4';

        $this->assertSame($expected, $board->toFen());
    }

    /**
     * @test
     */
    public function undo_e4_b6_Nf3_Bb7_Bc4_Nc6_Ke2()
    {
        $board = new Board();

        $board->play('w', 'e4');
        $board->play('b', 'b6');
        $board->play('w', 'Nf3');
        $board->play('b', 'Bb7');
        $board->play('w', 'Bc4');
        $board->play('b', 'Nc6');
        $board->play('w', 'Ke2');

        $board->undo();

        $expected = 'r2qkbnr/pbpppppp/1pn5/8/2B1P3/5N2/PPPP1PPP/RNBQK2R w KQkq - 4 4';

        $this->assertSame($expected, $board->toFen());
    }

    /**
     * @test
     */
    public function undo_e4_e5_Nf3_Nf6_Be2_Be7_O_O_legal()
    {
        $board = new Board();

        $board->play('w', 'e4');
        $board->play('b', 'e5');
        $board->play('w', 'Nf3');
        $board->play('b', 'Nf6');
        $board->play('w', 'Be2');
        $board->play('b', 'Be7');
        $board->play('w', 'O-O');

        $board->undo();

        $expected = ['f1', 'g1'];

        $this->assertEquals($expected, $board->legal('e1'));
    }

    /**
     * @test
     */
    public function undo_e4_e5_Nf3_Nc6()
    {
        $board = new Board();

        $board->play('w', 'e4');
        $board->play('b', 'e5');
        $board->play('w', 'Nf3');
        $board->play('b', 'Nc6');

        $board->undo();
        $board->undo();
        $board->undo();
        $board->undo();

        $board->play('w', 'e4');

        $expected = [
            7 => [ 'r', 'n', 'b', 'q', 'k', 'b', 'n', 'r' ],
            6 => [ 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p' ],
            5 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            4 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            3 => [ '.', '.', '.', '.', 'P', '.', '.', '.' ],
            2 => [ '.', '.', '.', '.', '.', '.', '.', '.' ],
            1 => [ 'P', 'P', 'P', 'P', '.', 'P', 'P', 'P' ],
            0 => [ 'R', 'N', 'B', 'Q', 'K', 'B', 'N', 'R' ],
        ];

        $this->assertSame($expected, $board->toArray());
    }

    /**
     * @test
     */
    public function king_sqs_e4_e5_Nf3_Nf6_Bc4_Be7()
    {
        $board = new Board();

        $board->play('w', 'e4');
        $board->play('b', 'e5');
        $board->play('w', 'Nf3');
        $board->play('b', 'Nf6');
        $board->play('w', 'Bc4');
        $board->play('b', 'Be7');

        $king = $board->pieceBySq('e1');

        $expected = [
            'e2',
            'f1',
            'g1',
        ];

        $this->assertEqualsCanonicalizing($expected, $king->moveSqs());
    }

    /**
     * @test
     */
    public function legal_e4_e5_Nf3_Nf6_Bc4_Be7()
    {
        $board = new Board();

        $board->play('w', 'e4');
        $board->play('b', 'e5');
        $board->play('w', 'Nf3');
        $board->play('b', 'Nf6');
        $board->play('w', 'Bc4');
        $board->play('b', 'Be7');

        $expected = ['e2', 'f1', 'g1'];

        $this->assertEquals($expected, $board->legal('e1'));
    }

    /**
     * @test
     */
    public function play_lan_w_foo()
    {
        $this->expectException(\Chess\Exception\UnknownNotationException::class);

        $board = new Board();

        $board->playLan('w', 'foo');
    }

    /**
     * @test
     */
    public function play_lan_d2d3_d7d6___b8d7_d2f3()
    {
        $board = new Board();

        $this->assertTrue($board->playLan('w', 'd2d3'));
        $this->assertTrue($board->playLan('b', 'd7d6'));
        $this->assertTrue($board->playLan('w', 'e2e3'));
        $this->assertTrue($board->playLan('b', 'e7e6'));
        $this->assertTrue($board->playLan('w', 'b1d2'));
        $this->assertTrue($board->playLan('b', 'b8d7'));
        $this->assertTrue($board->playLan('w', 'd2f3'));
    }

    /**
     * @test
     */
    public function play_lan_d2d4_d7d5___a4b5_c6b5()
    {
        $board = new Board();

        $this->assertTrue($board->playLan('w', 'd2d4'));
        $this->assertTrue($board->playLan('b', 'd7d5'));
        $this->assertTrue($board->playLan('w', 'c2c4'));
        $this->assertTrue($board->playLan('b', 'd5c4'));
        $this->assertTrue($board->playLan('w', 'g1f3'));
        $this->assertTrue($board->playLan('b', 'b7b5'));
        $this->assertTrue($board->playLan('w', 'a2a4'));
        $this->assertTrue($board->playLan('b', 'c7c6'));
        $this->assertTrue($board->playLan('w', 'a4b5'));
        $this->assertTrue($board->playLan('b', 'c6b5'));
    }

    /**
     * @test
     */
    public function is_fivefold_repetition()
    {
        $board = new Board();

        $board->play('w', 'Nf3');
        $board->play('b', 'Nc6');
        $board->play('w', 'Ng1');
        $board->play('b', 'Nb8');

        $board->play('w', 'Nf3');
        $board->play('b', 'Nc6');
        $board->play('w', 'Ng1');
        $board->play('b', 'Nb8');

        $board->play('w', 'Nf3');
        $board->play('b', 'Nc6');
        $board->play('w', 'Ng1');
        $board->play('b', 'Nb8');

        $board->play('w', 'Nf3');
        $board->play('b', 'Nc6');
        $board->play('w', 'Ng1');
        $board->play('b', 'Nb8');

        $board->play('w', 'Nf3');

        $this->assertTrue($board->isFivefoldRepetition());
    }

    /**
     * @test
     */
    public function play_lan_e2e4_f7f5_d1h5()
    {
        $board = new Board();

        $this->assertTrue($board->playLan('w', 'e2e4'));
        $this->assertTrue($board->playLan('b', 'f7f5'));
        $this->assertTrue($board->playLan('w', 'd1h5'));

        $expected = '1.e4 f5 2.Qh5+';

        $this->assertSame($expected, $board->movetext());
    }

    /**
     * @test
     */
    public function play_h4_a5_h5_g5()
    {
        $board = new Board();

        $board->play('w', 'h4');
        $board->play('b', 'a5');
        $board->play('w', 'h5');
        $board->play('b', 'g5');

        $expected = ['h6', 'g6'];

        $this->assertEquals($expected, $board->legal('h5'));
    }

    /**
     * @test
     */
    public function play_lan_h2h4_a7a5_h4h5_g7g5()
    {
        $board = new Board();

        $board->playLan('w', 'h2h4');
        $board->playLan('b', 'a7a5');
        $board->playLan('w', 'h4h5');
        $board->playLan('b', 'g7g5');

        $expected = ['h6', 'g6'];

        $this->assertEquals($expected, $board->legal('h5'));
    }

    /**
     * @test
     */
    public function legal_a1()
    {
        $board = new Board();

        $expected = [];

        $this->assertEquals($expected, $board->legal('a1'));
    }

    /**
     * @test
     */
    public function legal_e2()
    {
        $board = new Board();

        $expected = ['e3', 'e4'];

        $this->assertEquals($expected, $board->legal('e2'));
    }

    /**
     * @test
     */
    public function legal_e7()
    {
        $board = new Board();

        $board->playLan('w', 'e2e4');

        $expected = ['e6', 'e5'];

        $this->assertEquals($expected, $board->legal('e7'));
    }

    /**
     * @test
     */
    public function legal_e1()
    {
        $board = (new SanPlay('1.f4 e5 2.e4 a6 3.Bc4 a5 4.Nh3 Qh4+'))->validate()->board;

        $expected = ['e2', 'f1'];

        $this->assertEquals($expected, $board->legal('e1'));
    }

    /**
     * @test
     */
    public function is_fifty_move_draw_C68()
    {
        $C68 = file_get_contents(self::DATA_FOLDER.'/opening/C68.pgn');

        $board = (new SanPlay($C68))->validate()->board;

        $this->assertFalse($board->isFiftyMoveDraw());
    }

    /**
     * @test
     */
    public function is_fifty_move_draw_endgame_49_moves()
    {
        $board = FenToBoardFactory::create('7k/8/8/8/8/8/8/K7 w - - 0 1');

        for ($i = 0; $i < 99; $i++) {
            if ($lan = (new RandomMove($board))->move()) {
                $board->playLan($board->turn, $lan);
            }
        }

        $this->assertFalse($board->isFiftyMoveDraw());
    }

    /**
     * @test
     */
    public function is_fifty_move_draw_endgame_50_moves()
    {
        $board = FenToBoardFactory::create('7k/8/8/8/8/8/8/K7 w - - 0 1');

        for ($i = 0; $i < 100; $i++) {
            if ($lan = (new RandomMove($board))->move()) {
                $board->playLan($board->turn, $lan);
            }
        }

        $this->assertTrue($board->isFiftyMoveDraw());
    }

    /**
     * @test
     */
    public function is_dead_position_draw_K_vs_k()
    {
        $board = FenToBoardFactory::create('8/5k2/8/8/8/2K5/8/8 w - - 0 1');

        $this->assertTrue($board->isDeadPositionDraw());
    }

    /**
     * @test
     */
    public function is_dead_position_draw_K_B_vs_k()
    {
        $board = FenToBoardFactory::create('8/5k2/8/8/8/2KB4/8/8 w - - 0 1');

        $this->assertTrue($board->isDeadPositionDraw());
    }

    /**
     * @test
     */
    public function is_dead_position_draw_K_B_vs_k_b()
    {
        $board = FenToBoardFactory::create('k2B4/b1K5/8/8/8/8/8/8 w - - 0 1');

        $this->assertTrue($board->isDeadPositionDraw());
    }

    /**
     * @test
     */
    public function is_dead_position_draw_K_B_B_vs_k()
    {
        $board = FenToBoardFactory::create('8/5k2/8/8/8/2KB4/4B3/8 w - - 0 1');

        $this->assertTrue($board->isDeadPositionDraw());
    }

    /**
     * @test
     */
    public function is_not_dead_position_draw_K_B_vs_k_b()
    {
        $board = FenToBoardFactory::create('k7/b1K5/8/8/8/8/4B3/8 w - - 0 1');

        $this->assertFalse($board->isDeadPositionDraw());
    }

    /**
     * @test
     */
    public function is_not_dead_position_draw_K_P_vs_k()
    {
        $board = FenToBoardFactory::create('8/5k2/8/8/8/2KP4/8/8 w - - 0 1');

        $this->assertFalse($board->isDeadPositionDraw());
    }

    /**
     * @test
     */
    public function is_not_dead_position_draw_K_B_B_vs_k()
    {
        $board = FenToBoardFactory::create('8/5k2/8/8/8/2KBB3/8/8 w - - 0 1');

        $this->assertFalse($board->isDeadPositionDraw());
    }

    /**
     * @test
     */
    public function c6_is_pinned_play_lan_c6e7()
    {
        $board = FenToBoardFactory::create('r1bqkbnr/ppp2ppp/2np4/1B2p3/4P3/5N2/PPPP1PPP/RNBQ1RK1 b kq -');

        $expected = [];

        $this->assertEquals($expected, $board->legal('c6'));
        $this->assertFalse($board->playLan('b', 'c6e7'));
    }

    /**
     * @test
     */
    public function c6_is_pinned_play_Ne7()
    {
        $board = FenToBoardFactory::create('r1bqkbnr/ppp2ppp/2np4/1B2p3/4P3/5N2/PPPP1PPP/RNBQ1RK1 b kq -');

        $expected = [];

        $this->assertEquals($expected, $board->legal('c6'));
        $this->assertTrue($board->play('b', 'Ne7'));
    }

    /**
     * @test
     */
    public function c3_defends_b4_and_d4()
    {
        $board = FenToBoardFactory::create('8/5k1r/5pp1/8/1N1B4/1KP5/8/8 w - -');

        $expected = ["b4", "d4"];

        $this->assertEquals($expected, $board->pieceBySq("c3")->defendedSqs());
    }

    /**
     * @test
     */
    public function e4_h6_e5_f5_h3_h5_exf6()
    {
        $expected = ['e6'];

        $board = new Board();

        $board->play('w', 'e4');
        $board->play('b', 'h6');
        $board->play('w', 'e5');
        $board->play('b', 'f5');
        $board->play('w', 'h3');
        $board->play('b', 'h5');
      
        $this->assertEquals($expected, $board->legal('e5'));
        $this->assertFalse($board->play('w', 'exf6'));
    }

    /**
     * @test
     */
    public function e2e4_h7h6_e4e5_f7f5_h2h3_h6h5_e5f6()
    {
        $expected = ['e6'];

        $board = new Board();

        $board->playLan('w', 'e2e4');
        $board->playLan('b', 'h7h6');
        $board->playLan('w', 'e4e5');
        $board->playLan('b', 'f7f5');
        $board->playLan('w', 'h2h3');
        $board->playLan('b', 'h6h5');
      
        $this->assertEquals($expected, $board->legal('e5'));
        $this->assertFalse($board->playLan('w', 'e5f6'));
    }

    /**
     * @test
     */
    public function e4_h5_e5_f5_h3_g5()
    {
        $expected = ['e6'];

        $board = new Board();

        $board->play('w', 'e4');
        $board->play('b', 'h5');
        $board->play('w', 'e5');
        $board->play('b', 'f5');
        $board->play('w', 'h3');
        $board->play('b', 'g5');
      
        $this->assertEquals($expected, $board->legal('e5'));
        $this->assertFalse($board->play('w', 'exf6'));
    }

    /**
     * @test
     */
    public function e4_h5_e5_f5_h3_g6()
    {
        $expected = ['e6'];

        $board = new Board();

        $board->play('w', 'e4');
        $board->play('b', 'h5');
        $board->play('w', 'e5');
        $board->play('b', 'f5');
        $board->play('w', 'h3');
        $board->play('b', 'g6');
      
        $this->assertEquals($expected, $board->legal('e5'));
        $this->assertFalse($board->play('w', 'exf6'));
    }

    /**
     * @test
     */
    public function d4_a6_f4_a5_d5_a4_f5_e5_h3_c5()
    {
        $expected = ['f6'];

        $board = new Board();

        $board->play('w', 'd4');
        $board->play('b', 'a6');
        $board->play('w', 'f4');
        $board->play('b', 'a5');
        $board->play('w', 'd5');
        $board->play('b', 'a4');

        $board->play('w', 'f5');
        $board->play('b', 'e5');

        $board->play('w', 'h3');
        $board->play('b', 'c5');
      
        $this->assertEquals($expected, $board->legal('f5'));
        $this->assertFalse($board->play('w', 'fxe6'));
    }
}
