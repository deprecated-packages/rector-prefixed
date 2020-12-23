<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\Naming;

use _PhpScoper0a2ac50786fa\Nette\Utils\Strings;
final class ClassNaming
{
    public function getShortName(string $class) : string
    {
        if (\_PhpScoper0a2ac50786fa\Nette\Utils\Strings::contains($class, '\\')) {
            return (string) \_PhpScoper0a2ac50786fa\Nette\Utils\Strings::after($class, '\\', -1);
        }
        return $class;
    }
}
