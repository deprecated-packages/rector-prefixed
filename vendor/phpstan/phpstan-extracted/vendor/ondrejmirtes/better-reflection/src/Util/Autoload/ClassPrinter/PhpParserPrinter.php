<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Autoload\ClassPrinter;

use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Namespace_;
use _PhpScoperb75b35f52b74\PhpParser\PrettyPrinter\Standard as CodePrinter;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass;
final class PhpParserPrinter implements \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Autoload\ClassPrinter\ClassPrinterInterface
{
    public function __invoke(\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass $classInfo) : string
    {
        $nodes = [];
        if ($classInfo->inNamespace()) {
            $nodes[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Namespace_(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name($classInfo->getNamespaceName()));
        }
        $nodes[] = $classInfo->getAst();
        return (new \_PhpScoperb75b35f52b74\PhpParser\PrettyPrinter\Standard())->prettyPrint($nodes);
    }
}
