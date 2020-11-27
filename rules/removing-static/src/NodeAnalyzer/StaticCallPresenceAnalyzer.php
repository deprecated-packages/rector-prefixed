<?php

declare (strict_types=1);
namespace Rector\RemovingStatic\NodeAnalyzer;

use PhpParser\Node;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\Core\ValueObject\MethodName;
use Rector\NodeTypeResolver\NodeTypeResolver;
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
    public function __construct(\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function hasMethodStaticCallOnType(\PhpParser\Node\Stmt\ClassMethod $classMethod, string $type) : bool
    {
        return (bool) $this->betterNodeFinder->findFirst((array) $classMethod->stmts, function (\PhpParser\Node $node) use($type) : bool {
            if (!$node instanceof \PhpParser\Node\Expr\StaticCall) {
                return \false;
            }
            return $this->nodeTypeResolver->isObjectType($node->class, $type);
        });
    }
    public function hasClassAnyMethodWithStaticCallOnType(\PhpParser\Node\Stmt\Class_ $class, string $type) : bool
    {
        foreach ($class->getMethods() as $classMethod) {
            // handled else where
            if ((string) $classMethod->name === \Rector\Core\ValueObject\MethodName::CONSTRUCT) {
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
