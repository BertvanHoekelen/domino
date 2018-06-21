<?php

namespace Magwel\Domino\Application\Service\Exception;

class PlayerCannotPlayTile extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Player was unable to play tile.');
    }
}
