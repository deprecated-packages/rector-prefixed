<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PhpParser\ErrorHandler;

use _PhpScoper0a2ac50786fa\PhpParser\Error;
use _PhpScoper0a2ac50786fa\PhpParser\ErrorHandler;
/**
 * Error handler that handles all errors by throwing them.
 *
 * This is the default strategy used by all components.
 */
class Throwing implements \_PhpScoper0a2ac50786fa\PhpParser\ErrorHandler
{
    public function handleError(\_PhpScoper0a2ac50786fa\PhpParser\Error $error)
    {
        throw $error;
    }
}
