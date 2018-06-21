<?php

namespace Magwel\Domino\Test\Application\Service;

use Mockery;
use Hamcrest\Matchers;
use Magwel\Domino\Test\TestCase;
use Magwel\Domino\Domain\Model\Tile\Tile;
use Magwel\Domino\Domain\Model\Tile\TileRepository;
use Magwel\Domino\Application\Service\CreateStockService;

class CreateStockServiceTest extends TestCase
{
    /** @test */
    public function stock_has_28_tiles()
    {
        $tileRepository = Mockery::mock(TileRepository::class);
        $tileRepository->shouldReceive('add')->times(28);

        $createStockService = new CreateStockService($tileRepository);

        $createStockService->handle();
    }

    /** @test */
    public function stock_has_correct_tiles()
    {
        $tileRepository = Mockery::mock(TileRepository::class);

        $this->shouldReceiveAddWith($tileRepository, [
            new Tile(0, 0),
            new Tile(0, 1),
            new Tile(1, 1),
            new Tile(0, 2),
            new Tile(1, 2),
            new Tile(2, 2),
            new Tile(0, 3),
            new Tile(1, 3),
            new Tile(2, 3),
            new Tile(3, 3),
            new Tile(0, 4),
            new Tile(1, 4),
            new Tile(2, 4),
            new Tile(3, 4),
            new Tile(4, 4),
            new Tile(0, 5),
            new Tile(1, 5),
            new Tile(2, 5),
            new Tile(3, 5),
            new Tile(4, 5),
            new Tile(5, 5),
            new Tile(0, 6),
            new Tile(1, 6),
            new Tile(2, 6),
            new Tile(3, 6),
            new Tile(4, 6),
            new Tile(5, 6),
            new Tile(6, 6),
        ]);

        $createStockService = new CreateStockService($tileRepository);

        $createStockService->handle();
    }

    private function shouldReceiveAddWith(TileRepository $tileRepository, array $tiles)
    {
        foreach ($tiles as $tile) {
            $tileRepository->shouldReceive('add')->once()->with(Matchers::equalTo($tile));
        }
    }
}
