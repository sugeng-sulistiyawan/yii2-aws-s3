<?php

namespace diecoding\aws\s3\interfaces\commands;

/**
 * Interface HasAcl
 *
 * @package diecoding\aws\s3\interfaces\commands
 */
interface HasAcl
{
    /**
     * @param string $acl
     */
    public function withAcl(string $acl);
}
