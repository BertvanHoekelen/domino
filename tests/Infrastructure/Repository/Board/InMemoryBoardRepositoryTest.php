<?php

namespace Magwel\Domino\Test\Infrastructure\Repository\Board;

use Magwel\Domino\Test\TestCase;
use Magwel\Domino\Domain\Model\Tile\Tile;
use Magwel\Domino\Infrastructure\Repository\Board\InMemoryBoardRepository;

class InMemoryBoardRepositoryTest extends TestCase
{
    /** @test */
    public function can_add_left_tile_to_board()
    {
        $tile = new Tile(0, 0);
        $boardRepository = new InMemoryBoardRepository();

        $boardRepository->addLeftTile($tile);

        $this->assertEquals($tile, $boardRepository->getLeftTile());
    }

    /** @test */
    public function can_add_right_tile_to_board()
    {
        $tile = new Tile(0, 0);
        $boardRepository = new InMemoryBoardRepository();

        $boardRepository->addLeftTile(new Tile(5, 5));
        $boardRepository->addRightTile($tile);

        $this->assertEquals($tile, $boardRepository->getRightTile());
    }

    /** @test */
    public function can_check_if_board_is_empty()
    {
        $boardRepository = new InMemoryBoardRepository();

        $this->assertTrue($boardRepository->isEmpty());
    }

    /** @test */
    public function can_check_if_board_is_not_empty()
    {
        $boardRepository = new InMemoryBoardRepository();
        $boardRepository->addLeftTile(new Tile(5, 5));

        $this->assertFalse($boardRepository->isEmpty());
    }

    /** @test */
    public function can_get_all_tiles_on_the_board()
    {
        $boardRepository = new InMemoryBoardRepository();
        $tile1 = new Tile(5, 5);
        $tile2 = new Tile(4, 5);
        $boardRepository->addLeftTile($tile1);
        $boardRepository->addLeftTile($tile2);

        $this->assertEquals([
            $tile2,
            $tile1,
        ], $boardRepository->getStock());
    }
}
