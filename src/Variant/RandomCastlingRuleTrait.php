<?php

namespace Chess\Variant;

use Chess\Variant\Classical\PGN\Castle;
use Chess\Variant\Classical\PGN\Color;
use Chess\Variant\Classical\PGN\Piece;

trait RandomCastlingRuleTrait
{
    public array $shuffle;

    public array $startFiles;

    public array $size;

    protected function sq()
    {
        $longCastlingRook = false;
        foreach ($this->shuffle as $key => $val) {
            $wSq = chr(97 + $key) . '1';
            $bSq = chr(97 + $key) . $this->size['ranks'];
            if ($val === Piece::R) {
                if (!$longCastlingRook) {
                    $this->rule[Color::W][Castle::LONG][3][0] = $wSq;
                    $this->rule[Color::B][Castle::LONG][3][0] = $bSq;
                    $longCastlingRook = true;
                } else {
                    $this->rule[Color::W][Castle::SHORT][3][0] = $wSq;
                    $this->rule[Color::B][Castle::SHORT][3][0] = $bSq;
                }
            } elseif ($val === Piece::K) {
                $this->rule[Color::W][Castle::LONG][2][0] = $wSq;
                $this->rule[Color::B][Castle::LONG][2][0] = $bSq;
                $this->rule[Color::W][Castle::SHORT][2][0] = $wSq;
                $this->rule[Color::B][Castle::SHORT][2][0] = $bSq;
            }
        }

        return $this;
    }

    protected function moveSqs()
    {
        $kPath = $this->path(
            $this->rule[Color::W][Castle::SHORT][2][0],
            $this->rule[Color::W][Castle::SHORT][2][1]
        );

        $rPath = $this->path(
            $this->rule[Color::W][Castle::SHORT][3][0],
            $this->rule[Color::W][Castle::SHORT][3][1]
        );

        $path = array_unique([...$kPath, ...$rPath]);

        $this->rule[Color::W][Castle::SHORT][1] = $kPath;
        $this->rule[Color::W][Castle::SHORT][0] = array_diff($path, [
            $this->rule[Color::W][Castle::SHORT][2][0],
            $this->rule[Color::W][Castle::SHORT][3][0],
        ]);

        $kPath = $this->path(
            $this->rule[Color::W][Castle::LONG][2][0],
            $this->rule[Color::W][Castle::LONG][2][1]
        );

        $rPath = $this->path(
            $this->rule[Color::W][Castle::LONG][3][0],
            $this->rule[Color::W][Castle::LONG][3][1]
        );

        $path = array_unique([...$kPath, ...$rPath]);

        $this->rule[Color::W][Castle::LONG][1] = $kPath;
        $this->rule[Color::W][Castle::LONG][0] = array_diff($path, [
            $this->rule[Color::W][Castle::LONG][2][0],
            $this->rule[Color::W][Castle::LONG][3][0],
        ]);

        $kPath = $this->path(
            $this->rule[Color::B][Castle::SHORT][2][0],
            $this->rule[Color::B][Castle::SHORT][2][1]
        );

        $rPath = $this->path(
            $this->rule[Color::B][Castle::SHORT][3][0],
            $this->rule[Color::B][Castle::SHORT][3][1]
        );

        $path = array_unique([...$kPath, ...$rPath]);

        $this->rule[Color::B][Castle::SHORT][1] = $kPath;
        $this->rule[Color::B][Castle::SHORT][0] = array_diff($path, [
            $this->rule[Color::B][Castle::SHORT][2][0],
            $this->rule[Color::B][Castle::SHORT][3][0],
        ]);

        $kPath = $this->path(
            $this->rule[Color::B][Castle::LONG][2][0],
            $this->rule[Color::B][Castle::LONG][2][1]
        );

        $rPath = $this->path(
            $this->rule[Color::B][Castle::LONG][3][0],
            $this->rule[Color::B][Castle::LONG][3][1]
        );

        $path = array_unique([...$kPath, ...$rPath]);

        $this->rule[Color::B][Castle::LONG][1] = $kPath;
        $this->rule[Color::B][Castle::LONG][0] = array_diff($path, [
            $this->rule[Color::B][Castle::LONG][2][0],
            $this->rule[Color::B][Castle::LONG][3][0],
        ]);

        sort($this->rule[Color::W][Castle::SHORT][0]);
        sort($this->rule[Color::W][Castle::LONG][0]);
        sort($this->rule[Color::B][Castle::SHORT][0]);
        sort($this->rule[Color::B][Castle::LONG][0]);
    }

    protected function path(string $from, string $to)
    {
        $path = [];
        $i = ord($from[0]);
        $j = ord($to[0]);
        $min = min($i, $j);
        $max = max($i, $j);
        for ($min; $min <= $max; $min++) {
            $file = chr($min);
            $path[] = $file . $from[1];
        }

        return $path;
    }
}
