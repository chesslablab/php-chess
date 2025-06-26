<?php

namespace Chess\Tests\Unit\Variant\Capablanca\FEN;

use Chess\Exception\UnknownNotationException;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Capablanca\FEN\PiecePlacement;

class PiecePlacementTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function validate_foobar()
    {
        $this->expectException(UnknownNotationException::class);

        $piecePlacement = new PiecePlacement();

        $piecePlacement->validate('foobar');
    }

    /**
     * @test
     */
    public function validate_start_capablanca_80()
    {
        $expected = 'rnabqkbcnr/pppppppppp/10/10/10/10/PPPPPPPPPP/RNABQKBCNR';

        $piecePlacement = new PiecePlacement();

        $this->assertSame(
            $expected,
            $piecePlacement->validate('rnabqkbcnr/pppppppppp/10/10/10/10/PPPPPPPPPP/RNABQKBCNR')
        );
    }
}
