<?php

namespace Chess\Tests\Unit\UciEngine\Details;

use Chess\Tests\AbstractUnitTestCase;
use Chess\UciEngine\Details\Limit;

class LimitTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function instantiation()
    {
        $limit = new Limit();

        $this->assertTrue(is_a($limit, Limit::class));
        $this->assertSame(null, $limit->movetime);
        $this->assertSame(null, $limit->depth);
        $this->assertSame(null, $limit->nodes);
        $this->assertSame(null, $limit->mate);
        $this->assertSame(null, $limit->wtime);
        $this->assertSame(null, $limit->btime);
        $this->assertSame(null, $limit->winc);
        $this->assertSame(null, $limit->binc);
        $this->assertSame(null, $limit->movestogo);
    }

    /**
     * @test
     */
    public function time_3000()
    {
        $limit = new Limit();
        $limit->movetime = 3000;

        $this->assertSame(3000, $limit->movetime);
    }
}
