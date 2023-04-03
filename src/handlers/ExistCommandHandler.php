<?php

namespace diecoding\aws\s3\handlers;

use diecoding\aws\s3\base\handlers\Handler;
use diecoding\aws\s3\commands\ExistCommand;

/**
 * Class ExistCommandHandler
 *
 * @package diecoding\aws\s3\handlers
 */
final class ExistCommandHandler extends Handler
{
    /**
     * @param \diecoding\aws\s3\commands\ExistCommand $command
     *
     * @return bool
     */
    public function handle(ExistCommand $command): bool
    {
        return $this->s3Client->doesObjectExist(
            $command->getBucket(),
            $command->getFilename(),
            $command->getOptions()
        );
    }
}
