<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\PhpSpecToPHPUnit;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver;
final class LetManipulator
{
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function isLetNeededInClass(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        foreach ($class->getMethods() as $classMethod) {
            // new test
            if ($this->nodeNameResolver->isName($classMethod, 'test*')) {
                continue;
            }
            $hasBeConstructedThrough = (bool) $this->betterNodeFinder->find((array) $classMethod->stmts, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?bool {
                if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall) {
                    return null;
                }
                return $this->nodeNameResolver->isName($node->name, 'beConstructedThrough');
            });
            if ($hasBeConstructedThrough) {
                continue;
            }
            return \true;
        }
        return \false;
    }
}
