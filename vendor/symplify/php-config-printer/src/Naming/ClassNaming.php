<?php

declare (strict_types=1);
namespace RectorPrefix20210207\Symplify\PhpConfigPrinter\Naming;

use RectorPrefix20210207\Nette\Utils\Strings;
final class ClassNaming
{
    public function getShortName(string $class) : string
    {
        if (\RectorPrefix20210207\Nette\Utils\Strings::contains($class, '\\')) {
            return (string) \RectorPrefix20210207\Nette\Utils\Strings::after($class, '\\', -1);
        }
        return $class;
    }
}
