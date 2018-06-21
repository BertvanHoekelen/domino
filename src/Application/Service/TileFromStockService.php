<?php

namespace Magwel\Domino\Application\Service;

use Magwel\Domino\Domain\Model\Tile\Tile;
use Magwel\Domino\Domain\Model\Tile\TileRepository;
use Magwel\Domino\Application\Service\Exception\EmptyStockException;

class TileFromStockService
{
    /**
     * @var TileRepository
     */
    private $tileRepository;

    public function __construct(TileRepository $tileRepository)
    {
        $this->tileRepository = $tileRepository;
    }

    public function handle(): Tile
    {
        $tile = $this->tileRepository->takeFirst()[0] ?? null;

        if (!$tile) {
            throw new EmptyStockException();
        }

        return $tile;
    }
}
