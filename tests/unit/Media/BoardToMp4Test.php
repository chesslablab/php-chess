<?php

namespace Chess\Tests\Unit\Media;

use Chess\Media\BoardToMp4;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Chess960\FenToBoardFactory as Chess960FenToBoardFactory;
use Chess\Variant\Classical\FenToBoardFactory as ClassicalFenToBoardFactory;

class BoardToMp4Test extends AbstractUnitTestCase
{
    const OUTPUT_FOLDER = __DIR__.'/../../tmp';

    public static function tearDownAfterClass(): void
    {
        array_map('unlink', glob(self::OUTPUT_FOLDER . '/*.mp4'));
    }

    /**
     * @test
     */
    public function output_A74()
    {
        $A74 = file_get_contents(self::DATA_FOLDER.'/opening/A74.pgn');

        $board = ClassicalFenToBoardFactory::create();

        $filename = (new BoardToMp4(
            $A74,
            $board,
            $flip = false
        ))->output(
            $filepath = self::OUTPUT_FOLDER, 
            $filename = 'A74', 
            $r = 2, 
            $fps = 2, 
            $crf = 36, 
            $pixFmt = 'gray'
        );

        $this->assertTrue(file_exists(self::OUTPUT_FOLDER . '/' . $filename));
    }

    /**
     * @test
     */
    public function output_A74_staunty()
    {
        $A74 = file_get_contents(self::DATA_FOLDER.'/opening/A74.pgn');

        $board = ClassicalFenToBoardFactory::create();

        $filename = (new BoardToMp4(
            $A74,
            $board,
            $flip = false,
            $pieceSet = BoardToMp4::PIECE_SET_STAUNTY
        ))->output(
            $filepath = self::OUTPUT_FOLDER, 
            $filename = 'A74_staunty', 
            $r = 2, 
            $fps = 2, 
            $crf = 36, 
            $pixFmt = 'gray'
        );

        $this->assertTrue(file_exists(self::OUTPUT_FOLDER . '/' . $filename));
    }

    /**
     * @test
     */
    public function output_960_QRKRNNBB()
    {
        $board = Chess960FenToBoardFactory::create('qrkr1nbb/pppp2pp/3n1p2/4p3/4P3/4NP2/PPPP2PP/QRKRN1BB w KQkq -');

        $movetext = '1.Bf2 Re8 2.Nd3 O-O-O 3.O-O';

        $filename = (new BoardToMp4(
            $movetext,
            $board,
            $flip = false
        ))->output($filepath = self::OUTPUT_FOLDER);

        $this->assertTrue(file_exists(self::OUTPUT_FOLDER . '/' . $filename));
    }

    /**
     * @test
     */
    public function output_960_BNNBQRKR()
    {
        $board = Chess960FenToBoardFactory::create('b4rkr/ppppqppp/2nnpb2/8/4P3/2PP4/PP1NNPPP/B2BQRKR w KQkq -');

        $movetext = '1.Bc2 O-O-O 2.Qc1 Rhe8 3.Rd1 h6 4.O-O';

        $filename = (new BoardToMp4(
            $movetext,
            $board,
            $flip = false
        ))->output($filepath = self::OUTPUT_FOLDER);

        $this->assertTrue(file_exists(self::OUTPUT_FOLDER . '/' . $filename));
    }
}
