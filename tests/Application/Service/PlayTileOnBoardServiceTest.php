<?php

namespace Magwel\Domino\Test\Application\Service;

use Mockery;
use Magwel\Domino\Test\TestCase;
use Magwel\Domino\Domain\Model\Tile\Tile;
use Magwel\Domino\Domain\Model\Board\BoardRepository;
use Magwel\Domino\Application\Service\PlayTileOnBoardService;
use Magwel\Domino\Application\Service\Exception\TileCannotBePlacedOnTheBoard;

class PlayTileOnBoardServiceTest extends TestCase
{
    /** @test */
    public function can_play_tile_on_board_if_there_are_no_tiles_yet()
    {
        $tile = new Tile(0, 0);
        $boardRepository = Mockery::spy(BoardRepository::class);
        $boardRepository->shouldReceive('isEmpty')->andReturn(true);
        $playTileOnBoardService = new PlayTileOnBoardService($boardRepository);

        $playTileOnBoardService->handle($tile);
    }

    /** @test */
    public function can_play_tile_on_the_left_side_of_the_board()
    {
        $tile = new Tile(0, 0);
        $boardRepository = Mockery::spy(BoardRepository::class);
        $boardRepository->shouldReceive('isEmpty')->andReturn(false);
        $boardRepository->shouldReceive('getLeftTile')->andReturn(new Tile(0, 1));
        $playTileOnBoardService = new PlayTileOnBoardService($boardRepository);

        $playTileOnBoardService->handle($tile);
    }

    /** @test */
    public function can_play_tile_on_the_right_side_of_the_board()
    {
        $tile = new Tile(0, 0);
        $boardRepository = Mockery::spy(BoardRepository::class);
        $boardRepository->shouldReceive('isEmpty')->andReturn(false);
        $boardRepository->shouldReceive('getLeftTile')->andReturn(new Tile(1, 1));
        $boardRepository->shouldReceive('getRightTile')->andReturn(new Tile(1, 0));
        $playTileOnBoardService = new PlayTileOnBoardService($boardRepository);

        $playTileOnBoardService->handle($tile);
    }

    /** @test */
    public function left_tile_is_rotated_to_match_board()
    {
        $boardRepository = Mockery::spy(BoardRepository::class);
        $boardRepository->shouldReceive('isEmpty')->andReturn(false);
        $boardRepository->shouldReceive('getLeftTile')->andReturn(new Tile(0, 1));
        $boardRepository->shouldReceive('addLeftTile')->once()->withArgs(function(Tile $tile) {
            $this->assertEquals(5, $tile->getLeft());
            $this->assertEquals(0, $tile->getRight());

            return true;
        });
        $playTileOnBoardService = new PlayTileOnBoardService($boardRepository);

        $playTileOnBoardService->handle(new Tile(0, 5));
    }

    /** @test */
    public function right_tile_is_rotated_to_match_board()
    {
        $boardRepository = Mockery::spy(BoardRepository::class);
        $boardRepository->shouldReceive('isEmpty')->andReturn(false);
        $boardRepository->shouldReceive('getLeftTile')->andReturn(new Tile(1, 1));
        $boardRepository->shouldReceive('getRightTile')->andReturn(new Tile(1, 0));
        $boardRepository->shouldReceive('addRightTile')->once()->withArgs(function(Tile $tile) {
            $this->assertEquals(0, $tile->getLeft());
            $this->assertEquals(5, $tile->getRight());

            return true;
        });
        $playTileOnBoardService = new PlayTileOnBoardService($boardRepository);

        $playTileOnBoardService->handle(new Tile(5, 0));
    }

    /** @test */
    public function throw_exception_when_tile_cannot_be_placed_on_the_board()
    {
        $tile = new Tile(0, 0);
        $boardRepository = Mockery::spy(BoardRepository::class);
        $boardRepository->shouldReceive('isEmpty')->andReturn(false);
        $boardRepository->shouldReceive('getLeftTile')->andReturn(new Tile(1, 1));
        $boardRepository->shouldReceive('getRightTile')->andReturn(new Tile(1, 1));
        $playTileOnBoardService = new PlayTileOnBoardService($boardRepository);

        try {
            $playTileOnBoardService->handle($tile);
        } catch (TileCannotBePlacedOnTheBoard $e) {
            $this->assertEquals('Tile <0:0> cannot be place on the board.', $e->getMessage());

            return;
        }

        $this->fail('When the tile cannot be placed on the board, an exception must be thrown');
    }
}
