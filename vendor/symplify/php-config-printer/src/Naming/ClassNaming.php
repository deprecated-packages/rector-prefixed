<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\Naming;

use _PhpScoper88fe6e0ad041\Nette\Utils\Strings;
final class ClassNaming
{
    public function getShortName(string $class) : string
    {
        if (\_PhpScoper88fe6e0ad041\Nette\Utils\Strings::contains($class, '\\')) {
            return (string) \_PhpScoper88fe6e0ad041\Nette\Utils\Strings::after($class, '\\', -1);
        }
        return $class;
    }
}
