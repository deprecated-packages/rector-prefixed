<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Autoload\ClassPrinter;

use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_;
use _PhpScopere8e811afab72\PhpParser\PrettyPrinter\Standard as CodePrinter;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass;
final class PhpParserPrinter implements \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Autoload\ClassPrinter\ClassPrinterInterface
{
    public function __invoke(\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass $classInfo) : string
    {
        $nodes = [];
        if ($classInfo->inNamespace()) {
            $nodes[] = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_(new \_PhpScopere8e811afab72\PhpParser\Node\Name($classInfo->getNamespaceName()));
        }
        $nodes[] = $classInfo->getAst();
        return (new \_PhpScopere8e811afab72\PhpParser\PrettyPrinter\Standard())->prettyPrint($nodes);
    }
}
