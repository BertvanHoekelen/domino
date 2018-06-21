<?php

namespace Magwel\Domino\Test\Domain\Model\Player;

use Magwel\Domino\Test\TestCase;
use Magwel\Domino\Domain\Model\Tile\Tile;
use Magwel\Domino\Domain\Model\Player\Player;
use Magwel\Domino\Domain\Model\Tile\Exception\CannotPlayTileException;

class PlayerTest extends TestCase
{
    /** @test */
    public function can_deal_tiles_to_player()
    {
        $player = new Player('John');
        $tile1 = new Tile(0, 0);
        $tile2 = new Tile(0, 1);

        $player->deal([$tile1, $tile2]);

        $this->assertEquals([
            $tile1,
            $tile2,
        ], $player->stock());
    }

    /** @test */
    public function adding_extra_tile_to_players_stock_keeps_other_tiles()
    {
        $player = new Player('John');
        $tile1 = new Tile(0, 0);
        $tile2 = new Tile(0, 1);
        $tile3 = new Tile(0, 1);

        $player->deal([$tile1, $tile2]);
        $player->deal([$tile3]);

        $this->assertEquals([
            $tile1,
            $tile2,
            $tile3,
        ], $player->stock());
    }

    /** @test */
    public function can_check_if_player_can_play_tile()
    {
        $player = new Player('John');
        $player->deal([new Tile(5, 5)]);

        $canPlay = $player->canPlay(5);

        $this->assertTrue($canPlay);
    }

    /** @test */
    public function can_check_if_player_cannot_play_tile()
    {
        $player = new Player('John');
        $player->deal([new Tile(5, 5)]);

        $canPlay = $player->canPlay(0);

        $this->assertFalse($canPlay);
    }

    /** @test */
    public function can_play_tile()
    {
        $tile = new Tile(5, 5);
        $player = (new Player('John'))->deal([$tile]);

        $playedTile = $player->play(5);

        $this->assertEquals($tile, $playedTile);
        $this->assertCount(0, $player->stock());
    }

    /** @test */
    public function throw_exception_when_tile_cannot_be_played()
    {
        $tile = new Tile(5, 5);
        $player = (new Player('John'))->deal([$tile]);

        try {
            $player->play(0);
        } catch (CannotPlayTileException $e) {
            $this->assertEquals('Cannot play tile.', $e->getMessage());

            return;
        }

        $this->fail('When player cannot play tile it should have thrown CannotPlayTileException.');
    }

    /** @test */
    public function can_check_if_player_is_out_of_stock()
    {
        $john = new Player('John');
        $jane = (new Player('Jane'))->deal([new Tile(0, 0)]);

        $this->assertTrue($john->outOfStock());
        $this->assertFalse($jane->outOfStock());
    }
}
