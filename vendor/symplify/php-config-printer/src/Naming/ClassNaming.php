<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\Naming;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
final class ClassNaming
{
    public function getShortName(string $class) : string
    {
        if (\_PhpScoperb75b35f52b74\Nette\Utils\Strings::contains($class, '\\')) {
            return (string) \_PhpScoperb75b35f52b74\Nette\Utils\Strings::after($class, '\\', -1);
        }
        return $class;
    }
}
