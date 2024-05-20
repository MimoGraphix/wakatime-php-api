<?php

namespace Mabasic\WakaTime\Exceptions;

use Throwable;

class PremiumSubscriptionMissingException extends \Exception
{
    public function __construct($message, int $code = 0, ?Throwable $previous = null)
    {
        $json = json_decode($message, true);
        parent::__construct($json['error'], $code, $previous);
    }
}