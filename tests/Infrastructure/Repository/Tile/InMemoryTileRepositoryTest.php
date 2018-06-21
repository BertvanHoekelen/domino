<?php

namespace Magwel\Domino\Test\Infrastructure\Repository\Tile;

use Magwel\Domino\Test\TestCase;
use Magwel\Domino\Domain\Model\Tile\Tile;
use Magwel\Domino\Infrastructure\Repository\Tile\InMemoryTileRepository;
use Magwel\Domino\Infrastructure\Repository\Tile\Exception\TileAlreadyExistsException;

class InMemoryTileRepositoryTest extends TestCase
{
    /** @test */
    public function can_add_tile()
    {
        $tile = new Tile(0, 0);
        $repository = new InMemoryTileRepository();

        $repository->add($tile);

        $this->assertContains($tile, $repository->tiles());
    }

    /** @test */
    public function can_only_add_a_tile_once()
    {
        $tile1 = new Tile(0, 0);
        $tile2 = new Tile(0, 0);
        $repository = new InMemoryTileRepository();

        try {
            $repository->add($tile1);
            $repository->add($tile2);
        } catch (TileAlreadyExistsException $e) {
            $this->assertEquals('Tile already exists.', $e->getMessage());
            return;
        }

        $this->fail('You should only be able to push a tile once.');
    }

    /** @test */
    public function can_take_first_tiles()
    {
        $tile1 = new Tile(0, 0);
        $tile2 = new Tile(0, 1);
        $tile3 = new Tile(1, 0);
        $repository = new InMemoryTileRepository();

        $repository->add($tile1);
        $repository->add($tile2);
        $repository->add($tile3);

        $takenTiles = $repository->takeFirst(2);

        $this->assertContains($tile1, $takenTiles);
        $this->assertContains($tile2, $takenTiles);
        $this->assertNotContains($tile3, $takenTiles);
    }
}
