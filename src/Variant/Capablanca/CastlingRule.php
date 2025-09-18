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
                [ 'g1', 'h1', 'i1' ],
                [ 'f1', 'g1', 'h1', 'i1' ],
                [ 'f1', 'i1' ],
                [ 'j1', 'h1' ],
            ],
            Castle::LONG => [
                [ 'b1', 'c1', 'd1', 'e1' ],
                [ 'c1', 'd1', 'e1', 'f1' ],
                [ 'f1', 'c1' ],
                [ 'a1', 'd1' ],
            ],
        ],
        Color::B => [
            Castle::SHORT => [
                [ 'g8', 'h8', 'i8' ],
                [ 'f8', 'g8', 'h8', 'i8' ],
                [ 'f8', 'i8' ],
                [ 'j8', 'h8' ],
            ],
            Castle::LONG => [
                [ 'b8', 'c8', 'd8', 'e8' ],
                [ 'c8', 'd8', 'e8', 'f8' ],
                [ 'f8', 'c8' ],
                [ 'a8', 'd8' ],
            ],
        ],
    ];
}
