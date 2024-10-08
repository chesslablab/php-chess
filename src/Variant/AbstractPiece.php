<?php

namespace Chess\Variant;

use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\PGN\AN\Piece;
use Chess\Variant\Classical\PGN\AN\Square;

abstract class AbstractPiece
{
    public string $color;

    public string $sq;

    public Square $square;

    public string $id;

    public array $mobility;

    public array $move;

    public AbstractBoard $board;

    public function __construct(string $color, string $sq, Square $square, string $id)
    {
        $this->color = $color;
        $this->sq = $sq;
        $this->square = $square;
        $this->id = $id;
    }

    abstract public function moveSqs(): array;

    abstract public function defendedSqs(): ?array;

    public function file(): string
    {
        return $this->sq[0];
    }

    public function rank(): int
    {
        return (int) substr($this->sq, 1);
    }

    public function oppColor(): string
    {
        return $this->board->color->opp($this->color);
    }

    public function attacked(): ?array
    {
        $attacked = [];
        foreach ($sqs = $this->moveSqs() as $sq) {
            if ($piece = $this->board->pieceBySq($sq)) {
                if ($piece->color === $this->oppColor()) {
                    $attacked[] = $piece;
                }
            }
        }

        return $attacked;
    }

    public function attacking(): ?array
    {
        $attacking = [];
        foreach ($this->board->pieces($this->oppColor()) as $piece) {
            if (in_array($this->sq, $piece->moveSqs())) {
                $attacking[] = $piece;
            }
        }

        return $attacking;
    }

    public function defended(): ?array
    {
        $defended = [];
        foreach ($this->defendedSqs() as $sq) {
            if ($piece = $this->board->pieceBySq($sq)) {
                if ($piece->id !== Piece::K) {
                    $defended[] = $piece;
                }
            }
        }

        return $defended;
    }

    public function defending(): ?array
    {
        $defending = [];
        foreach ($this->board->pieces($this->color) as $piece) {
            if (in_array($this->sq, $piece->defendedSqs())) {
                $defending[] = $piece;
            }
        }

        return $defending;
    }

    public function isAttackingKing(): bool
    {
        foreach ($this->attacked() as $piece) {
            if ($piece->id === Piece::K) {
                return true;
            }
        }

        return false;
    }

    public function isMovable(): bool
    {
        if ($this->move) {
            return in_array($this->move['sq']['next'], $this->moveSqs());
        }

        return false;
    }

    public function isPinned(): bool
    {
        $before = $this->board->piece($this->color, Piece::K)->attacking();
        $this->board->detach($this);
        $this->board->refresh();
        $after = $this->board->piece($this->color, Piece::K)->attacking();
        $this->board->attach($this);
        $this->board->refresh();

        return $this->board->diffPieces($before, $after) !== [];
    }

    public function lineOfAttack()
    {
        $sqs = [];
        $king = $this->board->piece($this->oppColor(), Piece::K);
        if ($this->file() === $king->file()) {
            if ($this->rank() > $king->rank()) {
                for ($i = 1; $i < $this->rank() - $king->rank(); $i++) {
                    $sqs[] = $this->file() . ($king->rank() + $i);
                }
            } else {
                for ($i = 1; $i < $king->rank() - $this->rank(); $i++) {
                    $sqs[] = $this->file() . ($king->rank() - $i);
                }
            }
        } elseif ($this->rank() === $king->rank()) {
            if ($this->file() > $king->file()) {
                for ($i = 1; $i < ord($this->file()) - ord($king->file()); $i++) {
                    $sqs[] = chr(ord($king->file()) + $i) . $this->rank();
                }
            } else {
                for ($i = 1; $i < ord($king->file()) - ord($this->file()); $i++) {
                    $sqs[] = chr(ord($king->file()) - $i) . $this->rank();
                }
            }
        } elseif (abs(ord($this->file()) - ord($king->file())) === abs(ord($this->rank()) - ord($king->rank()))) {
            if ($this->file() > $king->file() && $this->rank() < $king->rank()) {
                for ($i = 1; $i < $king->rank() - $this->rank(); $i++) {
                    $sqs[] = chr(ord($king->file()) + $i) . ($king->rank() - $i);
                }
            } elseif ($this->file() < $king->file() && $this->rank() < $king->rank()) {
                for ($i = 1; $i < $king->rank() - $this->rank(); $i++) {
                    $sqs[] = chr(ord($king->file()) - $i) . ($king->rank() - $i);
                }
            } elseif ($this->file() < $king->file() && $this->rank() > $king->rank()) {
                for ($i = 1; $i < $this->rank() - $king->rank(); $i++) {
                    $sqs[] = chr(ord($king->file()) - $i) . ($king->rank() + $i);
                }
            } else {
                for ($i = 1; $i < $this->rank() - $king->rank(); $i++) {
                    $sqs[] = chr(ord($king->file()) + $i) . ($king->rank() + $i);
                }
            }
        }

        return $sqs;
    }
}
