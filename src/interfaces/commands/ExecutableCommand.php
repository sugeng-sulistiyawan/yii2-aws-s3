<?php

namespace diecoding\aws\s3\interfaces\commands;

/**
 * Interface ExecutableCommand
 *
 * @package diecoding\aws\s3\interfaces\commands
 */
interface ExecutableCommand extends Command
{
    /**
     * @return mixed
     */
    public function execute();
}
