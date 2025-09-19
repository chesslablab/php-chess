<?php

namespace Chess\Variant\Losing\PGN;

use Chess\Variant\Classical\PGN\Move as ClassicalPgnMove;
use Chess\Variant\Classical\PGN\Square;

class Move extends ClassicalPgnMove
{
    const PIECE = '[BMNQR]{1}[a-h]{0,1}[1-8]{0,1}' . self::CAPTURE . Square::AN . self::CHECK;
    const PROMOTION = self::CAPTURE . '[a-h]{1}(1|8){1}' . '[=]{0,1}[BMNQR]{0,1}' . self::CHECK;
}
