<?php

namespace Magwel\Domino\Domain\Model\Tile;

interface TileRepository
{
    /**
     * Add one tile.
     *
     * @param Tile $tile
     */
    public function add(Tile $tile);

    /**
     * Get all tiles.
     *
     * @return array
     */
    public function tiles(): array;

    /**
     * Take the first {$amountOfTiles} tiles.
     *
     * @param int $amountOfTiles
     *
     * @return array
     */
    public function takeFirst(int $amountOfTiles = 1): array;
}
