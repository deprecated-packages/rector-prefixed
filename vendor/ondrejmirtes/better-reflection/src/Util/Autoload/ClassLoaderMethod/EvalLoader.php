<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Roave\BetterReflection\Util\Autoload\ClassLoaderMethod;

use _PhpScoper006a73f0e455\Roave\BetterReflection\Reflection\ReflectionClass;
use _PhpScoper006a73f0e455\Roave\BetterReflection\Util\Autoload\ClassPrinter\ClassPrinterInterface;
final class EvalLoader implements \_PhpScoper006a73f0e455\Roave\BetterReflection\Util\Autoload\ClassLoaderMethod\LoaderMethodInterface
{
    /** @var ClassPrinterInterface */
    private $classPrinter;
    public function __construct(\_PhpScoper006a73f0e455\Roave\BetterReflection\Util\Autoload\ClassPrinter\ClassPrinterInterface $classPrinter)
    {
        $this->classPrinter = $classPrinter;
    }
    public function __invoke(\_PhpScoper006a73f0e455\Roave\BetterReflection\Reflection\ReflectionClass $classInfo) : void
    {
        eval($this->classPrinter->__invoke($classInfo));
    }
}
