<?php

namespace Magwel\Domino\Infrastructure\Repository\Board;

use Magwel\Domino\Domain\Model\Tile\Tile;
use Magwel\Domino\Domain\Model\Board\BoardRepository;

class InMemoryBoardRepository implements BoardRepository
{
    private $stock = [];

    /**
     * Check if board is empty.
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return count($this->stock) === 0;
    }

    /**
     * Add tile to the left of the board.
     *
     * @param Tile $tile
     *
     * @return BoardRepository
     */
    public function addLeftTile(Tile $tile): BoardRepository
    {
        array_unshift($this->stock, $tile);

        return $this;
    }

    /**
     * Get left tile of the board.
     *
     * @return Tile
     */
    public function getLeftTile(): Tile
    {
        return $this->stock[0] ?? null;
    }

    /**
     * Add tile to the right of the board.
     *
     * @param Tile $tile
     *
     * @return BoardRepository
     */
    public function addRightTile(Tile $tile): BoardRepository
    {
        array_push($this->stock, $tile);

        return $this;
    }

    /**
     * Get right tile of the board.
     *
     * @return Tile
     */
    public function getRightTile(): Tile
    {
        return end($this->stock);
    }

    /**
     * Get all tiles on the board.
     *
     * @return array
     */
    public function getStock(): array
    {
        return $this->stock;
    }
}
