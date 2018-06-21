<?php

namespace Magwel\Domino\Test\UI\Console;

use Magwel\Domino\Test\TestCase;
use Magwel\Domino\UI\Console\ConsoleOutput;

class ConsoleOutputTest extends TestCase
{
    /** @test */
    public function can_output_info()
    {
        $output = new ConsoleOutput();

        $this->expectOutputString("\033[0mFooBar".PHP_EOL."\033[0m");

        $output->info('FooBar');
    }

    /** @test */
    public function can_output_warning()
    {
        $output = new ConsoleOutput();

        $this->expectOutputString("\033[33mFooBar".PHP_EOL."\033[0m");

        $output->warning('FooBar');
    }

    /** @test */
    public function can_output_success()
    {
        $output = new ConsoleOutput();

        $this->expectOutputString("\033[32mFooBar".PHP_EOL."\033[0m");

        $output->success('FooBar');
    }

    /** @test */
    public function can_output_error()
    {
        $output = new ConsoleOutput();

        $this->expectOutputString("\033[31mFooBar".PHP_EOL."\033[0m");

        $output->error('FooBar');
    }
}
