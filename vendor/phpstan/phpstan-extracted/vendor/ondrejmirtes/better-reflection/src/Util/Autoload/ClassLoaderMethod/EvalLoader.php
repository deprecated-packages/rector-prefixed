<?php

declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Autoload\ClassLoaderMethod;

use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Autoload\ClassPrinter\ClassPrinterInterface;
final class EvalLoader implements \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Autoload\ClassLoaderMethod\LoaderMethodInterface
{
    /** @var ClassPrinterInterface */
    private $classPrinter;
    public function __construct(\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Autoload\ClassPrinter\ClassPrinterInterface $classPrinter)
    {
        $this->classPrinter = $classPrinter;
    }
    public function __invoke(\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass $classInfo) : void
    {
        eval($this->classPrinter->__invoke($classInfo));
    }
}
