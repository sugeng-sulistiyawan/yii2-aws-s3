<?php

namespace diecoding\aws\s3\interfaces;

use diecoding\aws\s3\interfaces\commands\Command;

/**
 * Interface Bus
 *
 * @package diecoding\aws\s3\interfaces
 */
interface Bus
{
    /**
     * @param Command $command
     *
     * @return mixed
     */
    public function execute(Command $command);
}
