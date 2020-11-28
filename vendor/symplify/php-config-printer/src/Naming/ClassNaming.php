<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\Naming;

use _PhpScoperabd03f0baf05\Nette\Utils\Strings;
final class ClassNaming
{
    public function getShortName(string $class) : string
    {
        if (\_PhpScoperabd03f0baf05\Nette\Utils\Strings::contains($class, '\\')) {
            return (string) \_PhpScoperabd03f0baf05\Nette\Utils\Strings::after($class, '\\', -1);
        }
        return $class;
    }
}
