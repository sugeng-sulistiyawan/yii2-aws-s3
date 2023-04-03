<?php

namespace diecoding\aws\s3\interfaces\commands;

/**
 * Interface PlainCommand
 *
 * @package diecoding\aws\s3\interfaces\commands
 */
interface PlainCommand extends Command
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return array
     */
    public function toArgs(): array;
}
