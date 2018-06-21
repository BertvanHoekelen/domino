<?php

namespace Magwel\Domino\Application\Service;

use Magwel\Domino\Domain\Model\Tile\Tile;
use Magwel\Domino\Domain\Model\Tile\TileRepository;

class CreateStockService
{
    private const STOCK_TYPE = 6;

    /**
     * @var TileRepository
     */
    private $tileRepository;

    public function __construct(TileRepository $tileRepository)
    {
        $this->tileRepository = $tileRepository;
    }

    public function handle()
    {
        $tiles = $this->getStock();
        shuffle($tiles);

        foreach ($tiles as $tile) {
            $this->tileRepository->add($tile);
        }
    }

    /**
     * Get complete new stock.
     *
     * @return array
     */
    private function getStock(): array
    {
        $tiles = [];

        for ($left = 0; $left <= self::STOCK_TYPE; $left++) {
            for ($right = $left; $right <= self::STOCK_TYPE; $right++) {
                $tiles[] = new Tile($left, $right);
            }
        }

        return $tiles;
    }
}
