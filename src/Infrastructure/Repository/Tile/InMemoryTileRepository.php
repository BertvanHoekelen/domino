<?php

namespace Magwel\Domino\Infrastructure\Repository\Tile;

use Magwel\Domino\Domain\Model\Tile\Tile;
use Magwel\Domino\Domain\Model\Tile\TileRepository;
use Magwel\Domino\Infrastructure\Repository\Tile\Exception\TileAlreadyExistsException;

class InMemoryTileRepository implements TileRepository
{
    private $tiles = [];

    /**
     * Add one tile.
     *
     * @param Tile $tile
     */
    public function add(Tile $tile)
    {
        if (in_array($tile, $this->tiles)) {
            throw new TileAlreadyExistsException();
        }

        $this->tiles[] = $tile;
    }

    /**
     * Get all tiles.
     *
     * @return array
     */
    public function tiles(): array
    {
        return $this->tiles;
    }

    /**
     * Take the first {$amountOfTiles} tiles.
     *
     * @param int $amountOfTiles
     *
     * @return array
     */
    public function takeFirst(int $amountOfTiles = 1): array
    {
        return array_splice($this->tiles, 0, $amountOfTiles);
    }
}
