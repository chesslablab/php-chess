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
                'k_from' => 'f1',
                'k_to' => 'i1',
                'r_from' => 'j1',
                'r_to' => 'h1',
            ],
            Castle::LONG => [
                'free' => [ 'b1', 'c1', 'd1', 'e1' ],
                'attack' => [ 'c1', 'd1', 'e1', 'f1' ],
                'k_from' => 'f1',
                'k_to' => 'c1',
                'r_from' => 'a1',
                'r_to' => 'd1',
            ],
        ],
        Color::B => [
            Castle::SHORT => [
                'free' => [ 'g8', 'h8', 'i8' ],
                'attack' => [ 'f8', 'g8', 'h8', 'i8' ],
                'k_from' => 'f8',
                'k_to' => 'i8',
                'r_from' => 'j8',
                'r_to' => 'h8',
            ],
            Castle::LONG => [
                'free' => [ 'b8', 'c8', 'd8', 'e8' ],
                'attack' => [ 'c8', 'd8', 'e8', 'f8' ],
                'k_from' => 'f8',
                'k_to' => 'c8',
                'r_from' => 'a8',
                'r_to' => 'd8',
            ],
        ],
    ];
}
