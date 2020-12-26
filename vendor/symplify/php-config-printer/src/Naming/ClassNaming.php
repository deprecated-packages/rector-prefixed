<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\Naming;

use RectorPrefix20201226\Nette\Utils\Strings;
final class ClassNaming
{
    public function getShortName(string $class) : string
    {
        if (\RectorPrefix20201226\Nette\Utils\Strings::contains($class, '\\')) {
            return (string) \RectorPrefix20201226\Nette\Utils\Strings::after($class, '\\', -1);
        }
        return $class;
    }
}
