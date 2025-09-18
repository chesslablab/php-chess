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
                'k_from' => 'e1',
                'k_to' => 'g1',
                'r_from' => 'h1',
                'r_to' => 'f1',
            ],
            Castle::LONG => [
                'free' => [ 'b1', 'c1', 'd1' ],
                'attack' => [ 'c1', 'd1', 'e1' ],
                'k_from' => 'e1',
                'k_to' => 'c1',
                'r_from' => 'a1',
                'r_to' => 'd1',
            ],
        ],
        Color::B => [
            Castle::SHORT => [
                'free' => [ 'f8', 'g8' ],
                'attack' => [ 'e8', 'f8', 'g8' ],
                'k_from' => 'e8',
                'k_to' => 'g8',
                'r_from' => 'h8',
                'r_to' => 'f8',
            ],
            Castle::LONG => [
                'free' => [ 'b8', 'c8', 'd8' ],
                'attack' => [ 'c8', 'd8', 'e8' ],
                'k_from' => 'e8',
                'k_to' => 'c8',
                'r_from' => 'a8',
                'r_to' => 'd8',
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
