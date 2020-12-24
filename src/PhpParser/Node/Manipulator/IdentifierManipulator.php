<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Manipulator;

use _PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\NodeChanger\NodeMissingIdentifierException;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver;
/**
 * This class renames node identifier, e.g. ClassMethod rename:
 *
 * -public function someMethod()
 * +public function newMethod()
 */
final class IdentifierManipulator
{
    /**
     * @var string[]
     */
    private const NODE_CLASSES_WITH_IDENTIFIER = [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ClassConstFetch::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticCall::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod::class];
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @param ClassConstFetch|MethodCall|PropertyFetch|StaticCall|ClassMethod $node
     * @param string[] $renameMethodMap
     */
    public function renameNodeWithMap(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, array $renameMethodMap) : void
    {
        $this->ensureNodeHasIdentifier($node);
        $oldNodeMethodName = $this->resolveOldMethodName($node);
        if ($oldNodeMethodName === null) {
            return;
        }
        $node->name = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier($renameMethodMap[$oldNodeMethodName]);
    }
    /**
     * @param ClassConstFetch|MethodCall|PropertyFetch|StaticCall|ClassMethod $node
     */
    public function removeSuffix(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, string $suffixToRemove) : void
    {
        $this->ensureNodeHasIdentifier($node);
        $name = $this->nodeNameResolver->getName($node);
        if ($name === null) {
            return;
        }
        $newName = \_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::replace($name, \sprintf('#%s$#', $suffixToRemove), '');
        $node->name = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier($newName);
    }
    private function ensureNodeHasIdentifier(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : void
    {
        if (\in_array(\get_class($node), self::NODE_CLASSES_WITH_IDENTIFIER, \true)) {
            return;
        }
        throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\NodeChanger\NodeMissingIdentifierException(\sprintf('Node "%s" does not contain a "$name" property with "%s". Pass only one of "%s".', \get_class($node), \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier::class, \implode('", "', self::NODE_CLASSES_WITH_IDENTIFIER)));
    }
    private function resolveOldMethodName(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?string
    {
        if ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticCall) {
            return $this->nodeNameResolver->getName($node->name);
        }
        if ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall) {
            return $this->nodeNameResolver->getName($node->name);
        }
        return $this->nodeNameResolver->getName($node);
    }
}
