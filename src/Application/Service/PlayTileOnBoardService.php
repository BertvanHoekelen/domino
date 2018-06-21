<?php

namespace Magwel\Domino\Application\Service;

use Magwel\Domino\Domain\Model\Tile\Tile;
use Magwel\Domino\Domain\Model\Board\BoardRepository;
use Magwel\Domino\Application\Service\Exception\TileCannotBePlacedOnTheBoard;

class PlayTileOnBoardService
{
    /**
     * @var BoardRepository
     */
    private $boardRepository;

    public function __construct(BoardRepository $boardRepository)
    {
        $this->boardRepository = $boardRepository;
    }

    public function handle(Tile $tile): Tile
    {
        if ($this->boardRepository->isEmpty()) {
            $this->boardRepository->addLeftTile($tile);

            return $tile;
        }

        $leftTile = $this->boardRepository->getLeftTile();

        if ($tile->matches($leftTile->getLeft())) {
            if ($leftTile->getLeft() === $tile->getLeft()) {
                $tile->rotate();
            }

            $this->boardRepository->addLeftTile($tile);

            return $leftTile;
        }

        $rightTile = $this->boardRepository->getRightTile();

        if ($tile->matches($rightTile->getRight())) {
            if ($rightTile->getRight() === $tile->getRight()) {
                $tile->rotate();
            }

            $this->boardRepository->addRightTile($tile);

            return $rightTile;
        }

        throw new TileCannotBePlacedOnTheBoard($tile);
    }
}
