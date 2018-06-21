<?php

namespace Magwel\Domino\Application\Service;

use Magwel\Domino\Domain\Model\Tile\Tile;
use Magwel\Domino\Domain\Model\Player\Player;
use Magwel\Domino\Domain\Model\Board\BoardRepository;
use Magwel\Domino\Application\Service\Exception\PlayerCannotPlayTile;

class PlayerPlaysTileService
{
    /**
     * @var BoardRepository
     */
    private $boardRepository;

    public function __construct(BoardRepository $boardRepository)
    {
        $this->boardRepository = $boardRepository;
    }

    public function handle(Player $player): ?Tile
    {
        $leftTile = $this->boardRepository->getLeftTile();

        if ($leftTile && $player->canPlay($leftTile->getLeft())) {
            return $player->play($leftTile->getLeft());
        }

        $rightTile = $this->boardRepository->getRightTile();

        if ($rightTile && $player->canPlay($rightTile->getRight())) {
            return $player->play($rightTile->getRight());
        }

        throw new PlayerCannotPlayTile();
    }
}
