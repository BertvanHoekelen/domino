<?php

namespace Magwel\Domino\Test\Domain\Model\Tile;

use Magwel\Domino\Test\TestCase;
use Magwel\Domino\Domain\Model\Tile\Tile;

class TileTest extends TestCase
{
    /** @test */
    public function can_match_tile_on_left_side()
    {
        $tile = new Tile(0, 0);

        $match = $tile->matches(0);

        $this->assertTrue($match);
    }

    /** @test */
    public function cannot_match_tile_if_its_different()
    {
        $tile = new Tile(0, 1);

        $match = $tile->matches(4);

        $this->assertFalse($match);
    }

    /** @test */
    public function can_rotate_tile()
    {
        $tile = new Tile(0, 1);

        $rotated = $tile->rotate();

        $this->assertEquals(1, $rotated->getLeft());
        $this->assertEquals(0, $rotated->getRight());
    }
}
