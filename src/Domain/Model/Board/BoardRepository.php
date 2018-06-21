<?php

namespace Magwel\Domino\Domain\Model\Board;

use Magwel\Domino\Domain\Model\Tile\Tile;

interface BoardRepository
{
    /**
     * Check if board is empty.
     *
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * Add tile to the left of the board.
     *
     * @param Tile $tile
     *
     * @return BoardRepository
     */
    public function addLeftTile(Tile $tile): BoardRepository;

    /**
     * Get left tile of the board.
     *
     * @return Tile
     */
    public function getLeftTile(): Tile;

    /**
     * Add tile to the right of the board.
     *
     * @param Tile $tile
     *
     * @return BoardRepository
     */
    public function addRightTile(Tile $tile): BoardRepository;

    /**
     * Get right tile of the board.
     *
     * @return Tile
     */
    public function getRightTile(): Tile;

    /**
     * Get all tiles on the board.
     *
     * @return array
     */
    public function getStock(): array;
}
