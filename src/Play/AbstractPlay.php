<?php

namespace Chess\Play;

use Chess\Variant\AbstractBoard;

abstract class AbstractPlay
{
    protected AbstractBoard $initialBoard;

    public AbstractBoard $board;

    public array $fen;

    abstract public function validate(): AbstractPlay;
}
