<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\Naming;

use _PhpScoperf18a0c41e2d2\Nette\Utils\Strings;
final class ClassNaming
{
    public function getShortName(string $class) : string
    {
        if (\_PhpScoperf18a0c41e2d2\Nette\Utils\Strings::contains($class, '\\')) {
            return (string) \_PhpScoperf18a0c41e2d2\Nette\Utils\Strings::after($class, '\\', -1);
        }
        return $class;
    }
}
