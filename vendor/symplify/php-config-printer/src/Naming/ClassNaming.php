<?php

declare (strict_types=1);
namespace RectorPrefix20210105\Symplify\PhpConfigPrinter\Naming;

use RectorPrefix20210105\Nette\Utils\Strings;
final class ClassNaming
{
    public function getShortName(string $class) : string
    {
        if (\RectorPrefix20210105\Nette\Utils\Strings::contains($class, '\\')) {
            return (string) \RectorPrefix20210105\Nette\Utils\Strings::after($class, '\\', -1);
        }
        return $class;
    }
}
