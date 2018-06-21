<?php

namespace Magwel\Domino;

use Magwel\Domino\Application\Service\Exception\EmptyStockException;
use Magwel\Domino\Application\Service\Exception\PlayerCannotPlayTile;
use Magwel\Domino\Application\Service\PlayerPlaysTileService;
use Magwel\Domino\Application\Service\PlayTileOnBoardService;
use Magwel\Domino\Domain\Model\Board\BoardRepository;
use Magwel\Domino\Domain\Model\Player\Player;
use Magwel\Domino\Domain\Model\Tile\Tile;
use Magwel\Domino\UI\Output;
use Magwel\Domino\Domain\Model\Tile\TileRepository;
use Magwel\Domino\Domain\Model\Player\PlayerRepository;
use Magwel\Domino\Application\Service\CreateStockService;
use Magwel\Domino\Application\Service\TileFromStockService;
use Magwel\Domino\Application\Service\DealTilesToPlayersService;

class Game
{
    /**
     * @var TileRepository
     */
    private $tileRepository;

    /**
     * @var PlayerRepository
     */
    private $playerRepository;

    /**
     * @var BoardRepository
     */
    private $boardRepository;

    /**
     * @var Output
     */
    private $output;

    /**
     * @var CreateStockService
     */
    private $stockService;

    /**
     * @var DealTilesToPlayersService
     */
    private $dealTilesToPlayersService;

    /**
     * @var TileFromStockService
     */
    private $tileFromStockService;

    /**
     * @var PlayerPlaysTileService
     */
    private $playerPlaysTileService;

    /**
     * @var PlayTileOnBoardService
     */
    private $playTileOnBoardService;

    public function __construct(
        TileRepository $tileRepository,
        PlayerRepository $playerRepository,
        BoardRepository $boardRepository,
        Output $output
    ) {
        $this->tileRepository = $tileRepository;
        $this->playerRepository = $playerRepository;
        $this->boardRepository = $boardRepository;
        $this->output = $output;

        $this->stockService = new CreateStockService($this->tileRepository);
        $this->dealTilesToPlayersService = new DealTilesToPlayersService($this->playerRepository, $this->tileRepository);
        $this->tileFromStockService = new TileFromStockService($this->tileRepository);
        $this->playerPlaysTileService = new PlayerPlaysTileService($this->boardRepository);
        $this->playTileOnBoardService = new PlayTileOnBoardService($this->boardRepository);
    }

    /**
     * Create players and deal tiles to players.
     *
     * @param array $playerNames
     *
     * @return Game
     */
    public function setupForPlayers(array $playerNames): self
    {
        $this->stockService->handle();
        $this->dealTilesToPlayersService->handle($playerNames);

        return $this;
    }

    /**
     * Start the game.
     */
    public function start()
    {
        $firstTile = $this->tileFromStockService->handle();
        $this->playTileOnBoardService->handle($firstTile);

        $this->output->info('First tile: '.$firstTile);
        $players = $this->playerRepository->players();

        while (true) {
            foreach ($players as $player) {
                try {
                    $playedTile = $this->getPlayableCardFromPlayer($player);
                } catch (EmptyStockException $e) {
                    $this->output->error('Game ended, no more tiles in stock');

                    break 2;
                }

                $boardTile = $this->playTileOnBoardService->handle($playedTile);

                $this->output->info($player . ' plays ' . $playedTile. ', to connect to tile '.$boardTile.' on the board.');

                $this->showBoardInfo();

                if ($player->outOfStock()) {
                    $this->output->success('Player ' . $player. ' has won!');

                    break 2;
                }
            }
        }
    }

    /**
     * Get card from player until they have a card that is suitable.
     *
     * @param $player
     *
     * @return Domain\Model\Tile\Tile
     */
    private function getPlayableCardFromPlayer(Player $player): Tile
    {
        while (true) {
            try {
                return $this->playerPlaysTileService->handle($player);
            }  catch (PlayerCannotPlayTile $e) {
                $tile = $this->tileFromStockService->handle();

                $player->deal([$tile]);

                $this->output->warning($player. ' can\'t play, drawing tile '.$tile);
            }
        }
    }

    /**
     * Output current board.
     */
    private function showBoardInfo()
    {
        $tiles = '';

        foreach ($this->boardRepository->getStock() as $tile) {
            $tiles .= $tile;
        }

        $this->output->info('Board is now: '.$tiles);
    }
}
