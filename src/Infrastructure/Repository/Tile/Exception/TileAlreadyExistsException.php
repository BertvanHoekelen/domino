<?php

namespace Magwel\Domino\Infrastructure\Repository\Tile\Exception;

class TileAlreadyExistsException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Tile already exists.');
    }
}
