<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PhpParser\ErrorHandler;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Error;
use _PhpScoper2a4e7ab1ecbc\PhpParser\ErrorHandler;
/**
 * Error handler that handles all errors by throwing them.
 *
 * This is the default strategy used by all components.
 */
class Throwing implements \_PhpScoper2a4e7ab1ecbc\PhpParser\ErrorHandler
{
    public function handleError(\_PhpScoper2a4e7ab1ecbc\PhpParser\Error $error)
    {
        throw $error;
    }
}
