<?php

namespace Chess\Media;

use Chess\Variant\AbstractBoard;
use Imagine\Gd\Imagine;
use Imagine\Image\Point;

class AbstractBoardToImg extends AbstractMedia
{
    protected AbstractBoard $board;

    protected bool $flip;

    protected string $pieceSet;

    protected Imagine $imagine;

    public function __construct(
        AbstractBoard $board,
        bool $flip = false,
        string $pieceSet = self::PIECE_SET_STANDARD
    )
    {
        $this->board = $board;
        $this->flip = $flip;
        $this->pieceSet = $pieceSet;
        $this->imagine = new Imagine();
    }

    public function setBoard(AbstractBoard $board): AbstractBoardToImg
    {
        $this->board = $board;

        return $this;
    }

    public function output(string $filepath, string $filename = ''): string
    {
        $filename ? $filename = $filename . $this->ext : $filename = uniqid() . $this->ext;
        $this->chessboard($filepath)->save("{$filepath}/{$filename}");

        return $filename;
    }

    protected function chessboard(string $filepath)
    {
        $nSqs = $this->board->square::SIZE['files'] * $this->board->square::SIZE['ranks'];
        $sqSize = self::BOARD_SIZE / $this->board->square::SIZE['files'];
        $chessboard = $this->imagine->open(self::IMG_PATH . '/chessboard/' . self::BOARD_SIZE . "_{$nSqs}" . '.png');
        $x = $y = 0;
        foreach ($this->board->toArray($this->flip) as $i => $rank) {
            foreach ($rank as $j => $piece) {
                if ($piece !== '.') {
                    $filename = trim($piece);
                    $image = $this->imagine->open(
                        self::IMG_PATH .
                        "/pieces/{$this->pieceSet}" .
                        "/png/" .
                        "/$sqSize" . (strtoupper($filename) === $filename ? '_white' : '_black') .
                        "/$filename.png"
                    );
                    $chessboard->paste($image, new Point($x, $y));
                }
                $x += $sqSize;
            }
            $x = 0;
            $y += $sqSize;
        }

        return $chessboard;
    }
}
