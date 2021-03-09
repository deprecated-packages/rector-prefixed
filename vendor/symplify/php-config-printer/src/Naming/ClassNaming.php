<?php

declare (strict_types=1);
namespace RectorPrefix20210309\Symplify\PhpConfigPrinter\Naming;

use RectorPrefix20210309\Nette\Utils\Strings;
final class ClassNaming
{
    public function getShortName(string $class) : string
    {
        if (\RectorPrefix20210309\Nette\Utils\Strings::contains($class, '\\')) {
            return (string) \RectorPrefix20210309\Nette\Utils\Strings::after($class, '\\', -1);
        }
        return $class;
    }
}
