<?php

namespace Magwel\Domino\Domain\Model\Player;

use Magwel\Domino\Domain\Model\Tile\Tile;
use Magwel\Domino\Domain\Model\Tile\Exception\CannotPlayTileException;

class Player
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $stock = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Add tile to players stock.
     *
     * @param array $tiles
     *
     * @return Player
     */
    public function deal(array $tiles): self
    {
        foreach ($tiles as $tile) {
            $this->stock[] = $tile;
        }

        return $this;
    }

    /**
     * Get players stock.
     *
     * @return array
     */
    public function stock(): array
    {
        return $this->stock;
    }

    /**
     * Check if player can play tile.
     *
     * @param int $number
     *
     * @return bool
     */
    public function canPlay(int $number): bool
    {
        return !!array_filter($this->stock, function(Tile $tile) use ($number) {
            return $tile->matches($number);
        });
    }

    /**
     * Play a tile for the player.
     *
     * @param int $number
     *
     * @return Tile
     * @throws CannotPlayTileException
     */
    public function play(int $number): Tile
    {
        foreach ($this->stock as $tileIndex => $tile) {
            if ($tile->matches($number)) {
                unset($this->stock[$tileIndex]);

                return $tile;
            }
        }

        throw new CannotPlayTileException();
    }

    /**
     * Check if player is out of stock.
     *
     * @return bool
     */
    public function outOfStock(): bool
    {
        return count($this->stock) === 0;
    }

    /**
     * Get string representation of player.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->name;
    }
}
