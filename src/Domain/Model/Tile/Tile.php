<?php

namespace Magwel\Domino\Domain\Model\Tile;

class Tile
{
    /**
     * @var int
     */
    private $left;

    /**
     * @var int
     */
    private $right;

    public function __construct(int $left, int $right)
    {
        $this->left = $left;
        $this->right = $right;
    }

    /**
     * Check if tile matches other tile.
     *
     * @param int $number
     *
     * @return bool
     */
    public function matches(int $number): bool
    {
        return $this->left === $number || $this->right === $number;
    }

    /**
     * Get left side of the tile.
     *
     * @return int
     */
    public function getLeft(): int
    {
        return $this->left;
    }

    /**
     * Get right side of the tile.
     *
     * @return int
     */
    public function getRight(): int
    {
        return $this->right;
    }

    /**
     * Get string representation of the tile.
     *
     * @return string
     */
    public function __toString(): string
    {
        return '<'.$this->left.':'.$this->right.'>';
    }

    /**
     * Swap left and right of tile.
     *
     * @return Tile
     */
    public function rotate(): Tile
    {
        $left = $this->right;

        $this->right = $this->left;
        $this->left = $left;

        return $this;
    }
}
