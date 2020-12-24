<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\Rector;

use Exception;
final class RectorNotFoundOrNotValidRectorClassException extends \Exception
{
    public function __construct(string $rector)
    {
        $message = \sprintf('"%s" was not found or is not valid Rector class', $rector);
        parent::__construct($message);
    }
}
