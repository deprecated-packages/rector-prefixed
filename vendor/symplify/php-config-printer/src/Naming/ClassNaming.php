<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\Naming;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
final class ClassNaming
{
    public function getShortName(string $class) : string
    {
        if (\_PhpScoper0a6b37af0871\Nette\Utils\Strings::contains($class, '\\')) {
            return (string) \_PhpScoper0a6b37af0871\Nette\Utils\Strings::after($class, '\\', -1);
        }
        return $class;
    }
}
