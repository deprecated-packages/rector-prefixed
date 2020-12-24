<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\Naming;

use _PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings;
final class ClassNaming
{
    public function getShortName(string $class) : string
    {
        if (\_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::contains($class, '\\')) {
            return (string) \_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::after($class, '\\', -1);
        }
        return $class;
    }
}
