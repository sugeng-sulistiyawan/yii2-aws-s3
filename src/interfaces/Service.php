<?php

namespace diecoding\aws\s3\interfaces;

use diecoding\aws\s3\interfaces\commands\Command;

/**
 * Interface Service
 *
 * @package diecoding\aws\s3\interfaces
 */
interface Service
{
    /**
     * @param Command $command
     *
     * @return mixed
     */
    public function execute(Command $command);

    /**
     * @param string $commandClass
     *
     * @return Command
     */
    public function create(string $commandClass): Command;
}
