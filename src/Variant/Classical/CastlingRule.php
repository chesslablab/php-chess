<?php

namespace Chess\Variant\Classical;

use Chess\Exception\UnknownNotationException;
use Chess\Variant\AbstractNotation;
use Chess\Variant\Classical\PGN\Castle;
use Chess\Variant\Classical\PGN\Color;

class CastlingRule extends AbstractNotation
{
    const START = 'KQkq';

    const NEITHER = '-';

    public array $rule = [
        Color::W => [
            Castle::SHORT => [
                0 => [ 'f1', 'g1' ], // free
                1 => [ 'e1', 'f1', 'g1' ], // attack
                2 => [ 'e1', 'g1' ], // king
                3 => [ 'h1', 'f1' ], // rook
            ],
            Castle::LONG => [
                0 => [ 'b1', 'c1', 'd1' ],
                1 => [ 'c1', 'd1', 'e1' ],
                2 => [ 'e1', 'c1' ],
                3 => [ 'a1', 'd1' ],
            ],
        ],
        Color::B => [
            Castle::SHORT => [
                0 => [ 'f8', 'g8' ],
                1 => [ 'e8', 'f8', 'g8' ],
                2 => [ 'e8', 'g8' ],
                3 => [ 'h8', 'f8' ],
            ],
            Castle::LONG => [
                0 => [ 'b8', 'c8', 'd8' ],
                1 => [ 'c8', 'd8', 'e8' ],
                2 => [ 'e8', 'c8' ],
                3 => [ 'a8', 'd8' ],
            ],
        ],
    ];

    public function validate(string $castlingAbility): string
    {
        if ($castlingAbility === self::NEITHER) {
            return $castlingAbility;
        } elseif (preg_match('/^K?Q?k?q?$/', $castlingAbility)) {
            return $castlingAbility;
        }

        throw new UnknownNotationException();
    }
}
