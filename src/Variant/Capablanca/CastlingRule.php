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
                'free' => [ 'g1', 'h1', 'i1' ],
                'attack' => [ 'f1', 'g1', 'h1', 'i1' ],
                'k' => [ 'f1', 'i1' ],
                'r' => [ 'j1', 'h1' ],
            ],
            Castle::LONG => [
                'free' => [ 'b1', 'c1', 'd1', 'e1' ],
                'attack' => [ 'c1', 'd1', 'e1', 'f1' ],
                'k' => [ 'f1', 'c1' ],
                'r' => [ 'a1', 'd1' ],
            ],
        ],
        Color::B => [
            Castle::SHORT => [
                'free' => [ 'g8', 'h8', 'i8' ],
                'attack' => [ 'f8', 'g8', 'h8', 'i8' ],
                'k' => [ 'f8', 'i8' ],
                'r' => [ 'j8', 'h8' ],
            ],
            Castle::LONG => [
                'free' => [ 'b8', 'c8', 'd8', 'e8' ],
                'attack' => [ 'c8', 'd8', 'e8', 'f8' ],
                'k' => [ 'f8', 'c8' ],
                'r' => [ 'a8', 'd8' ],
            ],
        ],
    ];
}
