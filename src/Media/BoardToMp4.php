<?php

namespace Chess\Media;

use Chess\Movetext\SanMovetext;
use Chess\Variant\AbstractBoard;

/**
 * Board To MP4 Conversion
 *
 * Text-based PGN movetexts can be easily converted to MP4, a widely-used video
 * format which comes in handy for pausing the games.
 */
class BoardToMp4 extends AbstractMedia
{
    /**
     * The maximum number of moves.
     *
     * @var int
     */
    const MAX_MOVES = 300;

    /**
     * The extension of the file.
     *
     * @var string
     */
    protected $ext = '.mp4';

    /**
     * The text-based PGN movetext in SAN format.
     *
     * @var \Chess\Movetext\SanMovetext
     */
    protected SanMovetext $sanMovetext;

    /**
     * The chess board.
     *
     * @var \Chess\Variant\AbstractBoard
     */
    protected AbstractBoard $board;

    /**
     * The orientation of the board.
     *
     * @var bool
     */
    protected bool $flip;

    /**
     * The piece set.
     *
     * @var string
     */
    protected string $pieceSet;

    /**
     * @param string $movetext
     * @param \Chess\Variant\AbstractBoard $board
     * @param bool $flip
     */
    public function __construct(
        string $movetext,
        AbstractBoard $board,
        bool $flip = false,
        string $pieceSet = self::PIECE_SET_STANDARD
    )
    {
        $this->sanMovetext = new SanMovetext($board->move, $movetext);
        if (!$this->sanMovetext->validate()) {
            throw new \InvalidArgumentException();
        }
        if (self::MAX_MOVES < count($this->sanMovetext->moves)) {
            throw new \InvalidArgumentException();
        }
        $this->board = $board;
        $this->flip = $flip;
        $this->pieceSet = $pieceSet;
    }

    /**
     * Creates the video file in the filesystem.
     * 
     * @param string $filepath
     * @param string $filename
     * @param int $r
     * @param int $fps
     * @param int $crf
     * @param string $pixFmt
     * @return string
     */
    public function output(
        string $filepath,
        string $filename = '',
        int $r = 2,
        int $fps = 2,
        int $crf = 28,
        string $pixFmt = 'yuv420p'
    ): string
    {
        if (!file_exists($filepath)) {
            throw new \InvalidArgumentException('The folder does not exist.');
        }
        
        $filename = $filename ? $filename . $this->ext : uniqid() . $this->ext; 

        $this->frames($filepath, $filename)
            ->animate(escapeshellarg($filepath), $filename, $r, $fps, $crf, $pixFmt)
            ->cleanup($filepath, $filename);

        return $filename;
    }

    /**
     * Creates the video frames in the filesystem.
     * 
     * @param string $filepath
     * @param string $filename
     * @return \Chess\Media\BoardToMp4
     */
    private function frames(string $filepath, string $filename): BoardToMp4
    {
        $boardToPng = new BoardToPng($this->board, $this->flip, $this->pieceSet);
        $boardToPng->output($filepath, "{$filename}_000");
        foreach ($this->sanMovetext->moves as $key => $val) {
            $n = sprintf("%03d", $key + 1);
            $this->board->play($this->board->turn, $val);
            $boardToPng->setBoard($this->board)->output($filepath, "{$filename}_{$n}");
        }

        return $this;
    }

    /**
     * Animates the video frames using ffmpeg.
     * 
     * @param string $filepath
     * @param string $filename
     * @param int $r
     * @param int $fps
     * @param int $crf
     * @param string $pixFmt
     * @return \Chess\Media\BoardToMp4
     */
    private function animate(
        string $filepath,
        string $filename,
        int $r = 2,
        int $fps = 2,
        int $crf = 28,
        string $pixFmt = 'yuv420p'
    ): BoardToMp4
    {
        $cmd = "ffmpeg
            -r $r
            -pattern_type glob
            -i {$filepath}/{$filename}*.png
            -vf fps=$fps
            -vcodec libx265
            -crf $crf
            -pix_fmt $pixFmt {$filepath}/{$filename}";
            
        exec(escapeshellcmd($cmd));

        return $this;
    }

    /**
     * Deletes the video frames from the filesystem.
     * 
     * @param string $filepath
     * @param string $filename
     */
    private function cleanup(string $filepath, string $filename): void
    {
        if (file_exists("{$filepath}/$filename")) {
            array_map('unlink', glob($filepath . '/*.png'));
        }
    }
}
