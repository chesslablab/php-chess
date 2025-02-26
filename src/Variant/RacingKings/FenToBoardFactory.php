<?php

namespace Chess\Variant\RacingKings;

use Chess\Exception\UnknownNotationException;
use Chess\Variant\AbstractBoard;
use Chess\Variant\PieceArrayFactory;
use Chess\Variant\Classical\CastlingRule;
use Chess\Variant\Classical\PGN\Square;
use Chess\Variant\RacingKings\FEN\Str;

/**
 * FEN to Board Factory
 *
 * A factory of Racing Kings chess boards.
 */
class FenToBoardFactory
{
    /**
     * @param string|null $string
     * @return \Chess\Variant\AbstractBoard
     */
    public static function create(string $string = null): AbstractBoard
    {
        if (!$string) {
            return new Board();
        }
        
        try {
            $fenStr = new Str();
            $string = $fenStr->validate($string);
            $fields = array_filter(explode(' ', $string));
            $namespace = 'RacingKings';
            $pieces = PieceArrayFactory::create(
                $fenStr->toArray($fields[0]),
                new Square(),
                new CastlingRule(),
                $namespace
            );
            $board = new Board($pieces, $fields[2]);
            $board->turn = $fields[1];
            $board->halfmoveClock = $fields[4] ?? 0;
            $board->fullmoveNumber = $fields[5] ?? 1;
            $board->startFen = "{$fields[0]} {$fields[1]} {$fields[2]} {$fields[3]} {$board->halfmoveClock} {$board->fullmoveNumber}";
        } catch (\Throwable $e) {
            throw new UnknownNotationException();
        }

        return $board;
    }
}
