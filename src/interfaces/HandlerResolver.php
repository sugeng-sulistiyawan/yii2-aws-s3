<?php

namespace diecoding\aws\s3\interfaces;

use diecoding\aws\s3\interfaces\commands\Command;
use diecoding\aws\s3\interfaces\handlers\Handler;

/**
 * Interface HandlerResolver
 *
 * @package diecoding\aws\s3\interfaces
 */
interface HandlerResolver
{
    /**
     * @param Command $command
     *
     * @return Handler
     */
    public function resolve(Command $command): Handler;

    /**
     * @param string $commandClass
     * @param mixed  $handler
     */
    public function bindHandler(string $commandClass, $handler);
}
