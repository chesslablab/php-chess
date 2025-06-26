<?php

namespace Chess\Variant;

trait AbstractBoardObserverTrait
{
    protected array $observers;

    public function notifyPieces(): void
    {
        foreach ($this->observers as $piece) {
            $piece->board = $this;
        }
    }

    public function attachPieces()
    {
        $this->rewind();
        while ($this->valid()) {
            $this->observers[] = $this->current();
            $this->next();
        }

        return $this;
    }

    public function detachPieces()
    {
        unset($this->observers);

        return $this;
    }
}
