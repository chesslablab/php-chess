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
                    $this->rule[Color::W][Castle::LONG]['r_from'] = $wSq;
                    $this->rule[Color::B][Castle::LONG]['r_from'] = $bSq;
                    $longCastlingRook = true;
                } else {
                    $this->rule[Color::W][Castle::SHORT]['r_from'] = $wSq;
                    $this->rule[Color::B][Castle::SHORT]['r_from'] = $bSq;
                }
            } elseif ($val === Piece::K) {
                $this->rule[Color::W][Castle::LONG]['k_from'] = $wSq;
                $this->rule[Color::B][Castle::LONG]['k_from'] = $bSq;
                $this->rule[Color::W][Castle::SHORT]['k_from'] = $wSq;
                $this->rule[Color::B][Castle::SHORT]['k_from'] = $bSq;
            }
        }

        return $this;
    }

    protected function moveSqs()
    {
        $kPath = $this->path(
            $this->rule[Color::W][Castle::SHORT]['k_from'],
            $this->rule[Color::W][Castle::SHORT]['k_to']
        );

        $rPath = $this->path(
            $this->rule[Color::W][Castle::SHORT]['r_from'],
            $this->rule[Color::W][Castle::SHORT]['r_to']
        );

        $path = array_unique([...$kPath, ...$rPath]);

        $this->rule[Color::W][Castle::SHORT]['attack'] = $kPath;
        $this->rule[Color::W][Castle::SHORT]['free'] = array_diff($path, [
            $this->rule[Color::W][Castle::SHORT]['k_from'],
            $this->rule[Color::W][Castle::SHORT]['r_from'],
        ]);

        $kPath = $this->path(
            $this->rule[Color::W][Castle::LONG]['k_from'],
            $this->rule[Color::W][Castle::LONG]['k_to']
        );

        $rPath = $this->path(
            $this->rule[Color::W][Castle::LONG]['r_from'],
            $this->rule[Color::W][Castle::LONG]['r_to']
        );

        $path = array_unique([...$kPath, ...$rPath]);

        $this->rule[Color::W][Castle::LONG]['attack'] = $kPath;
        $this->rule[Color::W][Castle::LONG]['free'] = array_diff($path, [
            $this->rule[Color::W][Castle::LONG]['k_from'],
            $this->rule[Color::W][Castle::LONG]['r_from'],
        ]);

        $kPath = $this->path(
            $this->rule[Color::B][Castle::SHORT]['k_from'],
            $this->rule[Color::B][Castle::SHORT]['k_to']
        );

        $rPath = $this->path(
            $this->rule[Color::B][Castle::SHORT]['r_from'],
            $this->rule[Color::B][Castle::SHORT]['r_to']
        );

        $path = array_unique([...$kPath, ...$rPath]);

        $this->rule[Color::B][Castle::SHORT]['attack'] = $kPath;
        $this->rule[Color::B][Castle::SHORT]['free'] = array_diff($path, [
            $this->rule[Color::B][Castle::SHORT]['k_from'],
            $this->rule[Color::B][Castle::SHORT]['r_from'],
        ]);

        $kPath = $this->path(
            $this->rule[Color::B][Castle::LONG]['k_from'],
            $this->rule[Color::B][Castle::LONG]['k_to']
        );

        $rPath = $this->path(
            $this->rule[Color::B][Castle::LONG]['r_from'],
            $this->rule[Color::B][Castle::LONG]['r_to']
        );

        $path = array_unique([...$kPath, ...$rPath]);

        $this->rule[Color::B][Castle::LONG]['attack'] = $kPath;
        $this->rule[Color::B][Castle::LONG]['free'] = array_diff($path, [
            $this->rule[Color::B][Castle::LONG]['k_from'],
            $this->rule[Color::B][Castle::LONG]['r_from'],
        ]);

        sort($this->rule[Color::W][Castle::SHORT]['free']);
        sort($this->rule[Color::W][Castle::LONG]['free']);
        sort($this->rule[Color::B][Castle::SHORT]['free']);
        sort($this->rule[Color::B][Castle::LONG]['free']);
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
