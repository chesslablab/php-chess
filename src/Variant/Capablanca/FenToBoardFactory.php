<?php

namespace Chess\Variant\Capablanca;

use Chess\Exception\UnknownNotationException;
use Chess\Variant\AbstractBoard;
use Chess\Variant\PieceArrayFactory;
use Chess\Variant\Capablanca\FEN\Str;
use Chess\Variant\Capablanca\PGN\Square;
use Chess\Variant\Classical\FenToBoardFactory as ClassicalFenToBoardFactory;

/**
 * FEN to Board Factory
 *
 * A factory of Capablanca chess boards.
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
            $namespace = 'Capablanca';
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
            ClassicalFenToBoardFactory::enPassant($fields, $board);
        } catch (\Throwable $e) {
            throw new UnknownNotationException();
        }

        return $board;
    }
}
