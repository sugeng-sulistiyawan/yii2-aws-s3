<?php

namespace diecoding\aws\s3\interfaces;

use diecoding\aws\s3\interfaces\commands\Command;

/**
 * Interface CommandBuilder
 *
 * @package diecoding\aws\s3\interfaces
 */
interface CommandBuilder
{
    /**
     * @param string $commandClass
     *
     * @return \diecoding\aws\s3\interfaces\commands\Command
     */
    public function build(string $commandClass): Command;
}
