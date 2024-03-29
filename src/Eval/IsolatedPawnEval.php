<?php

namespace Chess\Eval;

use Chess\Piece\P;
use Chess\Variant\Classical\Board;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\PGN\AN\Piece;

class IsolatedPawnEval extends AbstractEval implements InverseEvalInterface
{
    const NAME = 'Isolated pawn';

    public function __construct(Board $board)
    {
        $this->board = $board;

        $this->result = [
            Color::W => [],
            Color::B => [],
        ];

        foreach ($this->board->getPieces() as $piece) {
            if ($piece->getId() === Piece::P) {
                if ($this->isIsolatedPawn($piece)) {
                    $this->result[$piece->getColor()][] = $piece->getSq();
                }
            }
        }

        $this->explain($this->result);
    }

    private function isIsolatedPawn(P $pawn): int
    {
        $left = chr(ord($pawn->getSq()) - 1);
        $right = chr(ord($pawn->getSq()) + 1);
        for ($i = 2; $i < $this->board->getSize()['ranks']; $i++) {
            if ($piece = $this->board->getPieceBySq($left.$i)) {
                if ($piece->getId() === Piece::P && $piece->getColor() === $pawn->getColor()) {
                    return false;
                }
            }
            if ($piece = $this->board->getPieceBySq($right.$i)) {
                if ($piece->getId() === Piece::P && $piece->getColor() === $pawn->getColor()) {
                    return false;
                }
            }
        }

        return true;
    }

    private function explain(array $result): void
    {
        $singular = mb_strtolower('an ' . self::NAME);
        $plural = mb_strtolower(self::NAME.'s');

        $this->shorten($result, $singular, $plural);
    }
}
