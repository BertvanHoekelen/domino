<?php

namespace Magwel\Domino\Domain\Model\Tile\Exception;

class CannotPlayTileException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Cannot play tile.');
    }
}
