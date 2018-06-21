<?php

namespace Magwel\Domino\Test;

use Magwel\Domino\Game;
use Magwel\Domino\UI\Output;
use Magwel\Domino\Domain\Model\Tile\Tile;
use Magwel\Domino\Domain\Model\Player\Player;
use Magwel\Domino\Domain\Model\Tile\TileRepository;
use Magwel\Domino\Domain\Model\Board\BoardRepository;
use Magwel\Domino\Domain\Model\Player\PlayerRepository;

class GameTest extends TestCase
{
    /** @test */
    public function game_starts_with_open_tile()
    {
        $output = \Mockery::spy(Output::class);
        $boardRepository = \Mockery::spy(BoardRepository::class);
        $boardRepository->shouldReceive('getLeftTile')->andReturn(new Tile(4, 1));
        $boardRepository->shouldReceive('getRightTile')->andReturn(new Tile(4, 1));
        $tileRepository = \Mockery::spy(TileRepository::class);
        $tileRepository->shouldReceive('takeFirst')->andReturn([new Tile(4, 1)]);
        $playerRepository = \Mockery::spy(PlayerRepository::class);
        $playerRepository->shouldReceive('players')->andReturn([new Player('John')]);

        $output->shouldReceive('info')->once()->with('First tile: <1:4>');

        $game = new Game($tileRepository, $playerRepository, $boardRepository, $output);

        $game->setupForPlayers(['John']);
        $game->start();
    }

    /** @test */
    public function can_see_what_player_plays()
    {
        $output = \Mockery::spy(Output::class);
        $boardRepository = \Mockery::spy(BoardRepository::class);
        $boardRepository->shouldReceive('getLeftTile')->andReturn(new Tile(4, 1));
        $boardRepository->shouldReceive('getRightTile')->andReturn(new Tile(4, 1));
        $tileRepository = \Mockery::spy(TileRepository::class);
        $tileRepository->shouldReceive('takeFirst')->andReturn([new Tile(4, 1)]);
        $john = (new Player('John'))->deal([new Tile(4, 4)]);
        $playerRepository = \Mockery::spy(PlayerRepository::class);
        $playerRepository->shouldReceive('players')->andReturn([$john]);

        $output->shouldReceive('info')->once()->with('John plays <4:4>, to connect to tile <4:1> on the board.');

        $game = new Game($tileRepository, $playerRepository, $boardRepository, $output);

        $game->setupForPlayers(['John']);
        $game->start();
    }

    /** @test */
    public function get_board_info_after_player_played()
    {
        $output = \Mockery::spy(Output::class);
        $boardRepository = \Mockery::spy(BoardRepository::class);
        $boardRepository->shouldReceive('getStock')->andReturn([new Tile(4, 4), new Tile(4, 1)]);
        $boardRepository->shouldReceive('getLeftTile')->andReturn(new Tile(4, 1));
        $boardRepository->shouldReceive('getRightTile')->andReturn(new Tile(4, 1));
        $tileRepository = \Mockery::spy(TileRepository::class);
        $tileRepository->shouldReceive('takeFirst')->andReturn([new Tile(4, 1)]);
        $john = (new Player('John'))->deal([new Tile(4, 4)]);
        $playerRepository = \Mockery::spy(PlayerRepository::class);
        $playerRepository->shouldReceive('players')->andReturn([$john]);

        $output->shouldReceive('info')->once()->with('Board is now: <4:4><4:1>');

        $game = new Game($tileRepository, $playerRepository, $boardRepository, $output);

        $game->setupForPlayers(['John']);
        $game->start();
    }

    /** @test */
    public function can_see_winner()
    {
        $output = \Mockery::spy(Output::class);
        $boardRepository = \Mockery::spy(BoardRepository::class);
        $boardRepository->shouldReceive('getLeftTile')->andReturn(new Tile(4, 1));
        $boardRepository->shouldReceive('getRightTile')->andReturn(new Tile(4, 1));
        $tileRepository = \Mockery::spy(TileRepository::class);
        $tileRepository->shouldReceive('takeFirst')->andReturn([new Tile(4, 1)]);
        $john = (new Player('John'))->deal([new Tile(4, 4)]);
        $playerRepository = \Mockery::spy(PlayerRepository::class);
        $playerRepository->shouldReceive('players')->andReturn([$john]);

        $output->shouldReceive('success')->once()->with('Player John has won!');

        $game = new Game($tileRepository, $playerRepository, $boardRepository, $output);

        $game->setupForPlayers(['John']);
        $game->start();
    }

    /** @test */
    public function player_has_to_draw_tiles_from_stock_until_they_can()
    {
        $output = \Mockery::spy(Output::class);
        $tileRepository = \Mockery::spy(TileRepository::class);
        $boardRepository = \Mockery::spy(BoardRepository::class);
        $playerRepository = \Mockery::spy(PlayerRepository::class);

        $startTile = new Tile(0, 0);
        $tileRepository->expects()->takeFirst()->once()->andReturn([$startTile]);
        $tileRepository->expects()->takeFirst()->once()->andReturn([new Tile(6, 6)]);
        $tileRepository->expects()->takeFirst()->once()->andReturn([new Tile(2, 0)]);
        $boardRepository->expects()->isEmpty()->once()->andReturn(true);
        $boardRepository->expects()->isEmpty()->times(2)->andReturn(false);
        $boardRepository->expects()->getLeftTile()->times(6)->andReturn($startTile);
        $boardRepository->expects()->getRightTile()->times(2)->andReturn($startTile);

        $jane = (new Player('Jane'))->deal([new Tile(5, 5)]);
        $john = (new Player('Johne'))->deal([new Tile(0, 6)]);
        $playerRepository->shouldReceive('players')->andReturn([$jane, $john]);

        $output->shouldReceive('warning')->once()->with('Jane can\'t play, drawing tile <6:6>');
        $output->shouldReceive('warning')->once()->with('Jane can\'t play, drawing tile <2:0>');

        $game = new Game($tileRepository, $playerRepository, $boardRepository, $output);

        $game->setupForPlayers(['Jane', 'John']);
        $game->start();
    }

    /** @test */
    public function game_ends_when_stock_is_empty()
    {
        $output = \Mockery::spy(Output::class);
        $tileRepository = \Mockery::spy(TileRepository::class);
        $boardRepository = \Mockery::spy(BoardRepository::class);
        $playerRepository = \Mockery::spy(PlayerRepository::class);

        $startTile = new Tile(0, 0);
        $tileRepository->expects()->takeFirst()->once()->andReturn([$startTile]);
        $tileRepository->expects()->takeFirst()->once()->andReturn([new Tile(6, 6)]);
        $tileRepository->expects()->takeFirst()->once()->andReturn([]);
        $boardRepository->expects()->isEmpty()->once()->andReturn(true);
        $boardRepository->expects()->getLeftTile()->times(2)->andReturn($startTile);
        $boardRepository->expects()->getRightTile()->times(2)->andReturn($startTile);

        $jane = (new Player('Jane'))->deal([new Tile(5, 5)]);
        $john = (new Player('Johne'))->deal([new Tile(0, 6)]);
        $playerRepository->shouldReceive('players')->andReturn([$jane, $john]);

        $output->shouldReceive('error')->once()->with('Game ended, no more tiles in stock');

        $game = new Game($tileRepository, $playerRepository, $boardRepository, $output);

        $game->setupForPlayers(['Jane', 'John']);
        $game->start();
    }
}
