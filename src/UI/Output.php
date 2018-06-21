<?php

namespace Magwel\Domino\UI;

interface Output
{
    /**
     * Display success message.
     *
     * @param string $message
     *
     * @return mixed
     */
    public function success(string $message);

    /**
     * Display warning message.
     *
     * @param string $message
     *
     * @return mixed
     */
    public function warning(string $message);

    /**
     * Display info message.
     *
     * @param string $message
     *
     * @return mixed
     */
    public function info(string $message);

    /**
     * Display error message.
     *
     * @param string $message
     *
     * @return mixed
     */
    public function error(string $message);
}
