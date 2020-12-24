<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan;

final class ShouldNotHappenException extends \Exception
{
    public function __construct(string $message = 'Internal error.')
    {
        parent::__construct($message);
    }
}
