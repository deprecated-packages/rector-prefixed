<?php

declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Autoload\ClassPrinter;

use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\PrettyPrinter\Standard as CodePrinter;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass;
final class PhpParserPrinter implements \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Autoload\ClassPrinter\ClassPrinterInterface
{
    public function __invoke(\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass $classInfo) : string
    {
        $nodes = [];
        if ($classInfo->inNamespace()) {
            $nodes[] = new \PhpParser\Node\Stmt\Namespace_(new \PhpParser\Node\Name($classInfo->getNamespaceName()));
        }
        $nodes[] = $classInfo->getAst();
        return (new \PhpParser\PrettyPrinter\Standard())->prettyPrint($nodes);
    }
}
