<?php

namespace Chess\Tests\Unit\Media;

use Chess\Media\BoardToPng;
use Chess\Play\SanPlay;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Capablanca\Board as CapablancaBoard;
use Chess\Variant\Classical\Board as ClassicalBoard;
use Chess\Variant\Classical\FenToBoardFactory;

class BoardToPngTest extends AbstractUnitTestCase
{
    const OUTPUT_FOLDER = __DIR__.'/../../tmp';

    public static function tearDownAfterClass(): void
    {
        array_map('unlink', glob(self::OUTPUT_FOLDER . '/*.png'));
    }

    /**
     * @test
     */
    public function output_start()
    {
        $board = new ClassicalBoard();
        $filename = (new BoardToPng($board))->output(self::OUTPUT_FOLDER);

        $this->assertSame(
            sha1_file(self::OUTPUT_FOLDER.'/'.$filename),
            sha1_file(self::DATA_FOLDER.'/img/start.png')
        );
    }

    /**
     * @test
     */
    public function output_01_kaufman()
    {
        $board = FenToBoardFactory::create('1rbq1rk1/p1b1nppp/1p2p3/8/1B1pN3/P2B4/1P3PPP/2RQ1R1K w - -');
        $filename = (new BoardToPng($board))->output(self::OUTPUT_FOLDER);

        $this->assertSame(
            sha1_file(self::OUTPUT_FOLDER.'/'.$filename),
            sha1_file(self::DATA_FOLDER.'/img/01_kaufman.png')
        );
    }

    /**
     * @test
     */
    public function output_01_kaufman_staunty()
    {
        $board = FenToBoardFactory::create('1rbq1rk1/p1b1nppp/1p2p3/8/1B1pN3/P2B4/1P3PPP/2RQ1R1K w - -');
        $filename = (new BoardToPng(
            $board,
            $flip = false,
            $pieceSet = BoardToPng::PIECE_SET_STAUNTY
        ))->output(self::OUTPUT_FOLDER);

        $this->assertSame(
            sha1_file(self::OUTPUT_FOLDER.'/'.$filename),
            sha1_file(self::DATA_FOLDER.'/img/01_kaufman_staunty.png')
        );
    }

    /**
     * @test
     */
    public function output_01_kaufman_flip()
    {
        $board = FenToBoardFactory::create('1rbq1rk1/p1b1nppp/1p2p3/8/1B1pN3/P2B4/1P3PPP/2RQ1R1K w - -');
        $filename = (new BoardToPng($board, $flip = true))->output(self::OUTPUT_FOLDER);

        $this->assertSame(
            sha1_file(self::OUTPUT_FOLDER.'/'.$filename),
            sha1_file(self::DATA_FOLDER.'/img/01_kaufman_flip.png')
        );
    }

    /**
     * @test
     */
    public function output_A59()
    {
        $A59 = file_get_contents(self::DATA_FOLDER.'/opening/A59.pgn');
        $board = (new SanPlay($A59))->validate()->board;
        $filename = (new BoardToPng($board))->output(self::OUTPUT_FOLDER);

        $this->assertSame(
            sha1_file(self::OUTPUT_FOLDER.'/'.$filename),
            sha1_file(self::DATA_FOLDER.'/img/A59.png')
        );
    }

    /**
     * @test
     */
    public function output_A59_flip()
    {
        $A59 = file_get_contents(self::DATA_FOLDER.'/opening/A59.pgn');
        $board = (new SanPlay($A59))->validate()->board;
        $filename = (new BoardToPng($board, $flip = true))->output(self::OUTPUT_FOLDER);

        $this->assertSame(
            sha1_file(self::OUTPUT_FOLDER.'/'.$filename),
            sha1_file(self::DATA_FOLDER.'/img/A59_flip.png')
        );
    }

    /**
     * @test
     */
    public function output_capablanca_start()
    {
        $board = new CapablancaBoard();
        $filename = (new BoardToPng($board))->output(self::OUTPUT_FOLDER);

        $this->assertSame(
            sha1_file(self::OUTPUT_FOLDER.'/'.$filename),
            sha1_file(self::DATA_FOLDER.'/img/capablanca_start.png')
        );
    }

    /**
     * @test
     */
    public function output_capablanca_Nj3__O_O()
    {
        $board = new CapablancaBoard();
        $board->play('w', 'Nj3');
        $board->play('b', 'e5');
        $board->play('w', 'Ci3');
        $board->play('b', 'Nc6');
        $board->play('w', 'h3');
        $board->play('b', 'b6');
        $board->play('w', 'Bh2');
        $board->play('b', 'Ci6');
        $board->play('w', 'O-O');
        $filename = (new BoardToPng($board))->output(self::OUTPUT_FOLDER);

        $this->assertSame(
            sha1_file(self::OUTPUT_FOLDER.'/'.$filename),
            sha1_file(self::DATA_FOLDER.'/img/capablanca_Nj3__O_O.png')
        );
    }

    /**
     * @test
     */
    public function output_capablanca_f4__Nc6_flip()
    {
        $board = new CapablancaBoard();
        $board->play('w', 'f4');
        $board->play('b', 'f5');
        $board->play('w', 'Nh3');
        $board->play('b', 'Nc6');
        $filename = (new BoardToPng($board, $flip = true))->output(self::OUTPUT_FOLDER);

        $this->assertSame(
            sha1_file(self::OUTPUT_FOLDER.'/'.$filename),
            sha1_file(self::DATA_FOLDER.'/img/capablanca_f4__Nc6_flip.png')
        );
    }

    /**
     * @test
     */
    public function output_capablanca_f4__O_O_O_flip()
    {
        $board = new CapablancaBoard();
        $board->play('w', 'f4');
        $board->play('b', 'f5');
        $board->play('w', 'Nh3');
        $board->play('b', 'Nc6');
        $board->play('w', 'g3');
        $board->play('b', 'd6');
        $board->play('w', 'Ci3');
        $board->play('b', 'Ab6');
        $board->play('w', 'Bf2');
        $board->play('b', 'e6');
        $board->play('w', 'O-O');
        $board->play('b', 'Be7');
        $board->play('w', 'Nc3');
        $board->play('b', 'Qd7');
        $board->play('w', 'e3');
        $board->play('b', 'O-O-O');
        $filename = (new BoardToPng($board, $flip = true))->output(self::OUTPUT_FOLDER);

        $this->assertSame(
            sha1_file(self::OUTPUT_FOLDER.'/'.$filename),
            sha1_file(self::DATA_FOLDER.'/img/capablanca_f4__O_O_O_flip.png')
        );
    }
}
