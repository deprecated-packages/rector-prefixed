<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\Naming;

use RectorPrefix2020DecSat\Nette\Utils\Strings;
final class ClassNaming
{
    public function getShortName(string $class) : string
    {
        if (\RectorPrefix2020DecSat\Nette\Utils\Strings::contains($class, '\\')) {
            return (string) \RectorPrefix2020DecSat\Nette\Utils\Strings::after($class, '\\', -1);
        }
        return $class;
    }
}
