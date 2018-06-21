<?php

namespace Magwel\Domino\Application\Service;

use Magwel\Domino\Domain\Model\Player\Player;
use Magwel\Domino\Domain\Model\Tile\TileRepository;
use Magwel\Domino\Domain\Model\Player\PlayerRepository;

class DealTilesToPlayersService
{
    /**
     * @var PlayerRepository
     */
    private $playerRepository;

    /**
     * @var TileRepository
     */
    private $tileRepository;

    public function __construct(PlayerRepository $playerRepository, TileRepository $tileRepository)
    {
        $this->playerRepository = $playerRepository;
        $this->tileRepository = $tileRepository;
    }

    public function handle(array $playerNames)
    {
        foreach ($playerNames as $playerName) {
            $player = new Player($playerName);
            $tiles = $this->tileRepository->takeFirst(7);
            $player->deal($tiles);

            $this->playerRepository->add($player);
        }
    }
}
