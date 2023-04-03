<?php

namespace diecoding\aws\s3\handlers;

use diecoding\aws\s3\base\handlers\Handler;
use diecoding\aws\s3\commands\GetUrlCommand;

/**
 * Class GetUrlCommandHandler
 *
 * @package diecoding\aws\s3\handlers
 */
final class GetUrlCommandHandler extends Handler
{
    /**
     * @param \diecoding\aws\s3\commands\GetUrlCommand $command
     *
     * @return string
     */
    public function handle(GetUrlCommand $command): string
    {
        return $this->s3Client->getObjectUrl($command->getBucket(), $command->getFilename());
    }
}
