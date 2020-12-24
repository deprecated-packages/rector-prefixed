<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Naming;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
final class ClassNaming
{
    public function getShortName(string $class) : string
    {
        if (\_PhpScopere8e811afab72\Nette\Utils\Strings::contains($class, '\\')) {
            return (string) \_PhpScopere8e811afab72\Nette\Utils\Strings::after($class, '\\', -1);
        }
        return $class;
    }
}
