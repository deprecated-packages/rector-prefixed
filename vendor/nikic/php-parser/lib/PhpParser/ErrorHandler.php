<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PhpParser;

interface ErrorHandler
{
    /**
     * Handle an error generated during lexing, parsing or some other operation.
     *
     * @param Error $error The error that needs to be handled
     */
    public function handleError(\_PhpScoperb75b35f52b74\PhpParser\Error $error);
}
