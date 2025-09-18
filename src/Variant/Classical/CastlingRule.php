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
                'free' => [ 'f1', 'g1' ],
                'attack' => [ 'e1', 'f1', 'g1' ],
                'k' => [ 'e1', 'g1' ],
                'r' => [ 'h1', 'f1' ],
            ],
            Castle::LONG => [
                'free' => [ 'b1', 'c1', 'd1' ],
                'attack' => [ 'c1', 'd1', 'e1' ],
                'k' => [ 'e1', 'c1' ],
                'r' => [ 'a1', 'd1' ],
            ],
        ],
        Color::B => [
            Castle::SHORT => [
                'free' => [ 'f8', 'g8' ],
                'attack' => [ 'e8', 'f8', 'g8' ],
                'k' => [ 'e8', 'g8' ],
                'r' => [ 'h8', 'f8' ],
            ],
            Castle::LONG => [
                'free' => [ 'b8', 'c8', 'd8' ],
                'attack' => [ 'c8', 'd8', 'e8' ],
                'k' => [ 'e8', 'c8' ],
                'r' => [ 'a8', 'd8' ],
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
