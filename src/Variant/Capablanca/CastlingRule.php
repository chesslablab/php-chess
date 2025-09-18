<?php

namespace Chess\Variant\Capablanca;

use Chess\Variant\Classical\PGN\Castle;
use Chess\Variant\Classical\PGN\Color;
use Chess\Variant\Classical\CastlingRule as ClassicalCastlingRule;

class CastlingRule extends ClassicalCastlingRule
{
    public array $rule = [
        Color::W => [
            Castle::SHORT => [
                0 => [ 'g1', 'h1', 'i1' ],
                1 => [ 'f1', 'g1', 'h1', 'i1' ],
                2 => [ 'f1', 'i1' ],
                3 => [ 'j1', 'h1' ],
            ],
            Castle::LONG => [
                0 => [ 'b1', 'c1', 'd1', 'e1' ],
                1 => [ 'c1', 'd1', 'e1', 'f1' ],
                2 => [ 'f1', 'c1' ],
                3 => [ 'a1', 'd1' ],
            ],
        ],
        Color::B => [
            Castle::SHORT => [
                0 => [ 'g8', 'h8', 'i8' ],
                1 => [ 'f8', 'g8', 'h8', 'i8' ],
                2 => [ 'f8', 'i8' ],
                3 => [ 'j8', 'h8' ],
            ],
            Castle::LONG => [
                0 => [ 'b8', 'c8', 'd8', 'e8' ],
                1 => [ 'c8', 'd8', 'e8', 'f8' ],
                2 => [ 'f8', 'c8' ],
                3 => [ 'a8', 'd8' ],
            ],
        ],
    ];
}
