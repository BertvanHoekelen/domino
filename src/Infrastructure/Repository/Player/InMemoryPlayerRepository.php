<?php

namespace Magwel\Domino\Infrastructure\Repository\Player;

use Magwel\Domino\Domain\Model\Player\Player;
use Magwel\Domino\Domain\Model\Player\PlayerRepository;

class InMemoryPlayerRepository implements PlayerRepository
{
    private $players = [];

    /**
     * Add one player.
     *
     * @param Player $player
     *
     * @return InMemoryPlayerRepository
     */
    public function add(Player $player): PlayerRepository
    {
        $this->players[] = $player;

        return $this;
    }

    /**
     * Get all players.
     *
     * @return array
     */
    public function players(): array
    {
        return $this->players;
    }
}
