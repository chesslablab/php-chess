<?php

namespace Chess\Variant\Classical\PGN;

use Chess\Exception\UnknownNotationException;
use Chess\Variant\AbstractNotation;
use Chess\Variant\Classical\CastlingRule;
use Chess\Variant\Classical\PGN\Castle;
use Chess\Variant\Classical\PGN\Piece;
use Chess\Variant\Classical\PGN\Square;

class Move extends AbstractNotation
{
    const CAPTURE = '[a-h]{0,1}x{0,1}';
    const CHECK = '[\+\#]{0,1}';
    const ELLIPSIS = '...';

    const PIECE = '[BKNQR]{1}[a-h]{0,1}[1-8]{0,1}' . self::CAPTURE. Square::AN . self::CHECK;
    const PAWN = self::CAPTURE . Square::AN . self::CHECK;
    const CASTLE_SHORT = Castle::SHORT . self::CHECK;
    const CASTLE_LONG = Castle::LONG . self::CHECK;
    const PAWN_PROMOTES = self::CAPTURE . Square::AN . '[=]{0,1}[BNQR]{0,1}' . self::CHECK;

    public function validate(string $value): string
    {
        switch (true) {
            case preg_match('/^' . static::PIECE . '$/', $value):
                return $value;
            case preg_match('/^' . static::PAWN . '$/', $value):
                return $value;
            case preg_match('/^' . static::CASTLE_SHORT . '$/', $value):
                return $value;
            case preg_match('/^' . static::CASTLE_LONG . '$/', $value):
                return $value;
            case preg_match('/^' . static::PAWN_PROMOTES . '$/', $value):
                return $value;
        }

        throw new UnknownNotationException();
    }

    public function toArray(string $color, string $pgn, Square $square, CastlingRule $castlingRule = null): array
    {
        if (preg_match('/^' . static::PIECE . '$/', $pgn)) {
            $sqs = $square->extract($pgn);
            return [
                'pgn' => $pgn,
                'color' => $color,
                'id' => mb_substr($pgn, 0, 1),
                'from' => $sqs[0],
                'to' => $sqs[1],
            ];
        } elseif (preg_match('/^' . static::PAWN . '$/', $pgn)) {
            $sqs = $square->extract($pgn);
            return [
                'pgn' => $pgn,
                'color' => $color,
                'id' => Piece::P,
                'from' => $sqs[0],
                'to' => $sqs[1],
            ];
        } elseif (preg_match('/^' . static::CASTLE_SHORT . '$/', $pgn)) {
            return [
                'pgn' => $pgn,
                'color' => $color,
                'id' => Piece::K,
                'from' => $castlingRule?->rule[$color][Castle::SHORT][2][0],
                'to' => $castlingRule?->rule[$color][Castle::SHORT][2][1],
            ];
        } elseif (preg_match('/^' . static::CASTLE_LONG . '$/', $pgn)) {
            return [
                'pgn' => $pgn,
                'color' => $color,
                'id' => Piece::K,
                'from' => $castlingRule?->rule[$color][Castle::LONG][2][0],
                'to' => $castlingRule?->rule[$color][Castle::LONG][2][1],
            ];
        } elseif (preg_match('/^' . static::PAWN_PROMOTES . '$/', $pgn)) {
            $sqs = $square->extract($pgn);
            return [
                'pgn' => $pgn,
                'color' => $color,
                'id' => Piece::P,
                'newId' => substr(explode('=', $pgn)[1], 0, 1),
                'from' => $sqs[0],
                'to' => $sqs[1],
            ];
        }

        throw new UnknownNotationException($pgn);
    }
}
