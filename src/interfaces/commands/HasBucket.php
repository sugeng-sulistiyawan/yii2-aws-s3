<?php

namespace diecoding\aws\s3\interfaces\commands;

/**
 * Interface HasBucket
 *
 * @package diecoding\aws\s3\interfaces\commands
 */
interface HasBucket
{
    /**
     * @param string $name
     */
    public function inBucket(string $name);
}
