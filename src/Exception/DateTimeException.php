<?php

declare(strict_types=1);

namespace App\Exception;

use Throwable;

class DateTimeException extends SandboxException
{
    public const DEFAULT_MESSAGE = 'Invalid date time';

    public function __construct(string $message = self::DEFAULT_MESSAGE, ?Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
