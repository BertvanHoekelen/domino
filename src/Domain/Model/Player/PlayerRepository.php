<?php

namespace Magwel\Domino\Domain\Model\Player;

use Magwel\Domino\Infrastructure\Repository\Player\InMemoryPlayerRepository;

interface PlayerRepository
{
    /**
     * Add one player.
     *
     * @param Player $player
     *
     * @return InMemoryPlayerRepository
     */
    public function add(Player $player): PlayerRepository;

    /**
     * Get all players.
     *
     * @return Player[]
     */
    public function players(): array;
}
