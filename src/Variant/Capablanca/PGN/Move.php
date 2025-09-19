<?php

namespace Chess\Variant\Capablanca\PGN;

use Chess\Variant\Capablanca\PGN\Square;
use Chess\Variant\Classical\PGN\Move as ClassicalMove;

class Move extends ClassicalMove
{
    const CAPTURE = '[a-j]{0,1}x{0,1}';

    const PIECE = '[ABCKNQR]{1}[a-j]{0,1}[1-8]{0,1}' . self::CAPTURE . Square::AN . self::CHECK;
    const PAWN = self::CAPTURE. Square::AN . self::CHECK;
    const PAWN_PROMOTES = self::CAPTURE . Square::AN . '[=]{0,1}[ABCNQR]{0,1}' . self::CHECK;
}
