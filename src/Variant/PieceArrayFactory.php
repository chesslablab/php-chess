<?php

namespace Chess\Variant;

use Chess\Variant\AbstractNotation;
use Chess\Variant\Classical\R;
use Chess\Variant\Classical\PGN\Color;
use Chess\Variant\Classical\PGN\Piece;
use Chess\Variant\Classical\CastlingRule;

class PieceArrayFactory
{
    public static function create(
        array $array, 
        AbstractNotation $square, 
        CastlingRule $castlingRule = null, 
        string $namespace
    ): array
    {
        $pieces = [];
        foreach ($array as $i => $rank) {
            foreach ($rank as $j => $char) {
                if ($char !== '.') {
                    $sq = $square->toAn($j, $i);
                    if (ctype_lower($char)) {
                        $color = Color::B;
                        $char = strtoupper($char);
                    } else {
                        $color = Color::W;
                    }
                    if ($char === Piece::R) {
                        $pieces[] = new R($color, $sq, $square);
                    } else {
                        $class = VariantType::getClass($char, $namespace);
                        $pieces[] = new $class($color, $sq, $square);
                    }
                }
            }
        }

        return $pieces;
    }
}
