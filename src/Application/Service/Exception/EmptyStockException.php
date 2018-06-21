<?php

namespace Magwel\Domino\Application\Service\Exception;

class EmptyStockException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Stock is empty.');
    }
}
