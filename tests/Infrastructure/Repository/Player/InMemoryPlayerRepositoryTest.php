<?php

namespace Magwel\Domino\Test\Infrastructure\Repository\Player;

use Magwel\Domino\Test\TestCase;
use Magwel\Domino\Domain\Model\Player\Player;
use Magwel\Domino\Infrastructure\Repository\Player\InMemoryPlayerRepository;

class InMemoryPlayerRepositoryTest extends TestCase
{
    /** @test */
    public function can_add_player()
    {
        $repository = new InMemoryPlayerRepository();
        $john = new Player('John');

        $repository->add($john);

        $this->assertContains($john, $repository->players());
    }
}
