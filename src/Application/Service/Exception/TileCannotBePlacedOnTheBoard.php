<?php

namespace Magwel\Domino\Application\Service\Exception;

use Magwel\Domino\Domain\Model\Tile\Tile;

class TileCannotBePlacedOnTheBoard extends \RuntimeException
{
    public function __construct(Tile $tile)
    {
        parent::__construct('Tile '.$tile.' cannot be place on the board.');
    }
}
