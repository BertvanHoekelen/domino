<?php

namespace Magwel\Domino\UI\Console;

use Magwel\Domino\UI\Output;

class ConsoleOutput implements Output
{
    private const INFO = "\033[0m%s".PHP_EOL."\033[0m";
    private const WARNING = "\033[33m%s".PHP_EOL."\033[0m";
    private const SUCCESS = "\033[32m%s".PHP_EOL."\033[0m";
    private const ERROR = "\033[31m%s".PHP_EOL."\033[0m";

    /**
     * Display success message.
     *
     * @param string $message
     *
     * @return mixed
     */
    public function success(string $message)
    {
        echo sprintf(self::SUCCESS, $message);
    }

    /**
     * Display warning message.
     *
     * @param string $message
     *
     * @return mixed
     */
    public function warning(string $message)
    {
        echo sprintf(self::WARNING, $message);
    }

    /**
     * Display info message.
     *
     * @param string $message
     *
     * @return mixed
     */
    public function info(string $message)
    {
        echo sprintf(self::INFO, $message);
    }

    /**
     * Display error message.
     *
     * @param string $message
     *
     * @return mixed
     */
    public function error(string $message)
    {
        echo sprintf(self::ERROR, $message);
    }
}
