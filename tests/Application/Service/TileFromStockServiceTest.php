<?php

namespace Magwel\Domino\Test\Application\Service;

use Magwel\Domino\Application\Service\Exception\EmptyStockException;
use Mockery;
use Magwel\Domino\Test\TestCase;
use Magwel\Domino\Domain\Model\Tile\Tile;
use Magwel\Domino\Domain\Model\Tile\TileRepository;
use Magwel\Domino\Application\Service\TileFromStockService;

class TileFromStockServiceTest extends TestCase
{
    /** @test */
    public function can_get_tile_from_stock()
    {
        $tile = new Tile(0, 0);
        $tileRepository = Mockery::mock(TileRepository::class);
        $tileRepository->shouldReceive('takeFirst')->andReturn([$tile]);

        $tileFromStockService = new TileFromStockService($tileRepository);

        $this->assertEquals($tile, $tileFromStockService->handle());
    }

    /** @test */
    public function if_stock_is_empty_then_throw_empty_stock_exception()
    {
        $tile = new Tile(0, 0);
        $tileRepository = Mockery::mock(TileRepository::class);
        $tileRepository->shouldReceive('takeFirst')->andReturn([]);

        $tileFromStockService = new TileFromStockService($tileRepository);

        try {
            $this->assertEquals($tile, $tileFromStockService->handle());
        } catch (EmptyStockException $e) {
            $this->assertEquals('Stock is empty.', $e->getMessage());

            return;
        }

        $this->fail('If stock is empty, EmptyStockException should have been thrown');
    }
}
