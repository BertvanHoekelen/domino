<?php

namespace Magwel\Domino\Test\Application\Service;

use Mockery;
use Magwel\Domino\Test\TestCase;
use Magwel\Domino\Domain\Model\Tile\Tile;
use Magwel\Domino\Domain\Model\Player\Player;
use Magwel\Domino\Domain\Model\Board\BoardRepository;
use Magwel\Domino\Application\Service\PlayerPlaysTileService;
use Magwel\Domino\Application\Service\Exception\PlayerCannotPlayTile;

class PlayerPlaysTileServiceTest extends TestCase
{
    /** @test */
    public function player_can_play_tile_on_left_of_the_board()
    {
        $tile = new Tile(0, 0);
        $player = (new Player('John'))->deal([$tile]);
        $boardRepository = Mockery::spy(BoardRepository::class);
        $boardRepository->shouldReceive('getLeftTile')->andReturn($tile);
        $playerPlaysTileService = new PlayerPlaysTileService($boardRepository);

        $newTile = $playerPlaysTileService->handle($player);

        $this->assertEquals($tile, $newTile);
    }

    /** @test */
    public function player_can_play_tile_on_right_of_the_board()
    {
        $tile = new Tile(0, 0);
        $player = (new Player('John'))->deal([$tile]);
        $boardRepository = Mockery::spy(BoardRepository::class);
        $boardRepository->shouldReceive('getLeftTile')->andReturn(new Tile(5, 5));
        $boardRepository->shouldReceive('getRightTile')->andReturn($tile);
        $playerPlaysTileService = new PlayerPlaysTileService($boardRepository);

        $newTile = $playerPlaysTileService->handle($player);

        $this->assertEquals($tile, $newTile);
    }

    /** @test */
    public function throw_exception_when_player_cannot_play_tile()
    {
        $player = (new Player('John'))->deal([new Tile(0, 0)]);
        $boardRepository = Mockery::spy(BoardRepository::class);
        $boardRepository->shouldReceive('getLeftTile')->andReturn(new Tile(5, 5));
        $boardRepository->shouldReceive('getRightTile')->andReturn(new Tile(4, 4));
        $playerPlaysTileService = new PlayerPlaysTileService($boardRepository);

        try {
            $playerPlaysTileService->handle($player, new Tile(5, 5));
        } catch (PlayerCannotPlayTile $e) {
            $this->assertEquals('Player was unable to play tile.', $e->getMessage());

            return;
        }

        $this->fail('When player cannot play tile an exception should be thrown');
    }
}
