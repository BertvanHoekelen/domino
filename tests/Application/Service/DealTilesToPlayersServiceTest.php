<?php

namespace Magwel\Domino\Test\Application\Service;

use Mockery;
use Hamcrest\Matchers;
use Magwel\Domino\Test\TestCase;
use Magwel\Domino\Domain\Model\Tile\Tile;
use Magwel\Domino\Domain\Model\Player\Player;
use Magwel\Domino\Domain\Model\Tile\TileRepository;
use Magwel\Domino\Domain\Model\Player\PlayerRepository;
use Magwel\Domino\Application\Service\DealTilesToPlayersService;

class DealTilesToPlayersServiceTest extends TestCase
{
    /** @test */
    public function players_are_created()
    {
        $playerRepository = Mockery::mock(PlayerRepository::class);
        $playerRepository->shouldReceive('add')->once()->with(Matchers::equalTo(new Player('John')));
        $playerRepository->shouldReceive('add')->once()->with(Matchers::equalTo(new Player('Jane')));
        $playerRepository->shouldReceive('add')->once()->with(Matchers::equalTo(new Player('Henk')));
        $playerRepository->shouldReceive('add')->once()->with(Matchers::equalTo(new Player('Piet')));

        $createStockService = new DealTilesToPlayersService($playerRepository, Mockery::spy(TileRepository::class));

        $createStockService->handle(['John', 'Jane', 'Henk', 'Piet']);
    }

    /** @test */
    public function player_receive_7_tiles()
    {
        $tileRepository = Mockery::mock(TileRepository::class);
        $tileRepository->shouldReceive('takeFirst')->with(7)->andReturn([new Tile(0, 0)]);
        $playerRepository = Mockery::mock(PlayerRepository::class);
        $playerRepository->shouldReceive('add')->once()->withArgs(function (Player $player) {
            $this->assertCount(1, $player->stock());

            return true;
        });

        $createStockService = new DealTilesToPlayersService($playerRepository, $tileRepository);

        $createStockService->handle(['John']);
    }
}
