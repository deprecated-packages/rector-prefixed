<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\Naming;

use _PhpScoperfce0de0de1ce\Nette\Utils\Strings;
final class ClassNaming
{
    public function getShortName(string $class) : string
    {
        if (\_PhpScoperfce0de0de1ce\Nette\Utils\Strings::contains($class, '\\')) {
            return (string) \_PhpScoperfce0de0de1ce\Nette\Utils\Strings::after($class, '\\', -1);
        }
        return $class;
    }
}
