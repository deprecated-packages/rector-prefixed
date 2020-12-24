<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\RemovingStatic\NodeAnalyzer;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver;
final class StaticCallPresenceAnalyzer
{
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function hasMethodStaticCallOnType(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod, string $type) : bool
    {
        return (bool) $this->betterNodeFinder->findFirst((array) $classMethod->stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use($type) : bool {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall) {
                return \false;
            }
            return $this->nodeTypeResolver->isObjectType($node->class, $type);
        });
    }
    public function hasClassAnyMethodWithStaticCallOnType(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class, string $type) : bool
    {
        foreach ($class->getMethods() as $classMethod) {
            // handled else where
            if ((string) $classMethod->name === \_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::CONSTRUCT) {
                continue;
            }
            $hasStaticCall = $this->hasMethodStaticCallOnType($classMethod, $type);
            if ($hasStaticCall) {
                return \true;
            }
        }
        return \false;
    }
}
