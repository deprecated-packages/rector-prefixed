<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Roave\BetterReflection\Util\Autoload\ClassPrinter;

use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\PrettyPrinter\Standard as CodePrinter;
use _PhpScoper006a73f0e455\Roave\BetterReflection\Reflection\ReflectionClass;
final class PhpParserPrinter implements \_PhpScoper006a73f0e455\Roave\BetterReflection\Util\Autoload\ClassPrinter\ClassPrinterInterface
{
    public function __invoke(\_PhpScoper006a73f0e455\Roave\BetterReflection\Reflection\ReflectionClass $classInfo) : string
    {
        $nodes = [];
        if ($classInfo->inNamespace()) {
            $nodes[] = new \PhpParser\Node\Stmt\Namespace_(new \PhpParser\Node\Name($classInfo->getNamespaceName()));
        }
        $nodes[] = $classInfo->getAst();
        return (new \PhpParser\PrettyPrinter\Standard())->prettyPrint($nodes);
    }
}
