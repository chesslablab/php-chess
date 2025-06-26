<?php

namespace Chess\Variant\CapablancaFischer;

use Chess\Exception\UnknownNotationException;
use Chess\Variant\AbstractBoard;
use Chess\Variant\PieceArrayFactory;
use Chess\Variant\Capablanca\FEN\Str;
use Chess\Variant\Classical\FenToBoardFactory as ClassicalFenToBoardFactory;
use Chess\Variant\Capablanca\PGN\Square;

/**
 * FEN to Board Factory
 *
 * A factory of Capablanca-Fischer chess boards.
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
            return new Board((new Shuffle())->shuffle());
        }

        try {
            $fenStr = new Str();
            $string = $fenStr->validate($string);
            $fields = array_filter(explode(' ', $string));
            $namespace = 'Capablanca';
            $shuffle = (new Shuffle())->extract($string);
            $castlingRule = new CastlingRule($shuffle);
            $pieces = PieceArrayFactory::create(
                $fenStr->toArray($fields[0]),
                new Square(),
                $castlingRule,
                $namespace
            );
            $castlingAbility = $fields[2];
            $board = new Board($shuffle, $pieces, $castlingAbility);
            $board->turn = $fields[1];
            $board->halfmoveClock = $fields[4] ?? 0;
            $board->fullmoveNumber = $fields[5] ?? 1;
            $board->startFen = "{$fields[0]} {$fields[1]} {$castlingAbility} {$fields[3]} {$board->halfmoveClock} {$board->fullmoveNumber}";
            ClassicalFenToBoardFactory::enPassant($fields, $board);
        } catch (\Throwable $e) {
            throw new UnknownNotationException();
        }

        return $board;
    }
}
