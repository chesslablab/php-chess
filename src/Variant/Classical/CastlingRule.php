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
                [ 'f1', 'g1' ], // free
                [ 'e1', 'f1', 'g1' ], // attack
                [ 'e1', 'g1' ], // king
                [ 'h1', 'f1' ], // rook
            ],
            Castle::LONG => [
                [ 'b1', 'c1', 'd1' ],
                [ 'c1', 'd1', 'e1' ],
                [ 'e1', 'c1' ],
                [ 'a1', 'd1' ],
            ],
        ],
        Color::B => [
            Castle::SHORT => [
                [ 'f8', 'g8' ],
                [ 'e8', 'f8', 'g8' ],
                [ 'e8', 'g8' ],
                [ 'h8', 'f8' ],
            ],
            Castle::LONG => [
                [ 'b8', 'c8', 'd8' ],
                [ 'c8', 'd8', 'e8' ],
                [ 'e8', 'c8' ],
                [ 'a8', 'd8' ],
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
