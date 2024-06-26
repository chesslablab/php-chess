<?php

namespace Chess\Eval;

use Chess\Variant\AbstractBoard;
use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\PGN\AN\Piece;

class MaterialEval extends AbstractEval implements ExplainEvalInterface
{
    use ExplainEvalTrait;

    const NAME = 'Material';

    public function __construct(AbstractBoard $board)
    {
        $this->board = $board;

        $this->range = [1, 4];

        $this->subject = [
            'White',
            'Black',
        ];

        $this->observation = [
            "has a slight material advantage",
            "has a moderate material advantage",
            "has a decisive material advantage",
        ];

        foreach ($this->board->pieces(Color::W) as $piece) {
            if ($piece->id !== Piece::K) {
                $this->result[Color::W] += self::$value[$piece->id];
            }
        }

        foreach ($this->board->pieces(Color::B) as $piece) {
            if ($piece->id !== Piece::K) {
                $this->result[Color::B] += self::$value[$piece->id];
            }
        }

        $this->result[Color::W] = round($this->result[Color::W], 2);
        $this->result[Color::B] = round($this->result[Color::B], 2);

        $this->explain($this->result);
    }
}
