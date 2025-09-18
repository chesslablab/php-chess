<?php

namespace Chess\Variant;

use Chess\Variant\AbstractNotation;
use Chess\Variant\Classical\PGN\Color;
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
                    $class = VariantType::getClass(strtoupper($char), $namespace);
                    $color = ctype_lower($char) ? Color::B : Color::W;
                    $pieces[] = new $class($color, $square->toAn($j, $i), $square);
                }
            }
        }

        return $pieces;
    }
}
