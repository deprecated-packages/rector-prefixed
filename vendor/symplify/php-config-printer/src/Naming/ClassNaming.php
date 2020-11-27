<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\Naming;

use _PhpScopera143bcca66cb\Nette\Utils\Strings;
final class ClassNaming
{
    public function getShortName(string $class) : string
    {
        if (\_PhpScopera143bcca66cb\Nette\Utils\Strings::contains($class, '\\')) {
            return (string) \_PhpScopera143bcca66cb\Nette\Utils\Strings::after($class, '\\', -1);
        }
        return $class;
    }
}
