<?php

namespace diecoding\aws\s3\commands;

use diecoding\aws\s3\base\commands\ExecutableCommand;
use diecoding\aws\s3\base\commands\traits\Options;
use diecoding\aws\s3\interfaces\commands\HasBucket;

/**
 * Class ExistCommand
 *
 * @method bool execute()
 *
 * @package diecoding\aws\s3\commands
 */
class ExistCommand extends ExecutableCommand implements HasBucket
{
    use Options;

    /** @var string */
    protected $bucket;

    /** @var string */
    protected $filename;

    /**
     * @return string
     */
    public function getBucket(): string
    {
        return (string)$this->bucket;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function inBucket(string $name)
    {
        $this->bucket = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return (string)$this->filename;
    }

    /**
     * @param string $filename
     *
     * @return $this
     */
    public function byFilename(string $filename)
    {
        $this->filename = $filename;

        return $this;
    }
}
