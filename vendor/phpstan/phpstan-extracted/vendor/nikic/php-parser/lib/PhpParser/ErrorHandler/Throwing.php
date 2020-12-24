<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PhpParser\ErrorHandler;

use _PhpScoperb75b35f52b74\PhpParser\Error;
use _PhpScoperb75b35f52b74\PhpParser\ErrorHandler;
/**
 * Error handler that handles all errors by throwing them.
 *
 * This is the default strategy used by all components.
 */
class Throwing implements \_PhpScoperb75b35f52b74\PhpParser\ErrorHandler
{
    public function handleError(\_PhpScoperb75b35f52b74\PhpParser\Error $error)
    {
        throw $error;
    }
}
