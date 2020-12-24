<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PhpParser\ErrorHandler;

use _PhpScopere8e811afab72\PhpParser\Error;
use _PhpScopere8e811afab72\PhpParser\ErrorHandler;
/**
 * Error handler that handles all errors by throwing them.
 *
 * This is the default strategy used by all components.
 */
class Throwing implements \_PhpScopere8e811afab72\PhpParser\ErrorHandler
{
    public function handleError(\_PhpScopere8e811afab72\PhpParser\Error $error)
    {
        throw $error;
    }
}
