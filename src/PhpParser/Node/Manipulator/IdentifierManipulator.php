<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator;

use _PhpScoper0a2ac50786fa\Nette\Utils\Strings;
use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Identifier;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\Rector\Core\Exception\NodeChanger\NodeMissingIdentifierException;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver;
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
    private const NODE_CLASSES_WITH_IDENTIFIER = [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod::class];
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @param ClassConstFetch|MethodCall|PropertyFetch|StaticCall|ClassMethod $node
     * @param string[] $renameMethodMap
     */
    public function renameNodeWithMap(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, array $renameMethodMap) : void
    {
        $this->ensureNodeHasIdentifier($node);
        $oldNodeMethodName = $this->resolveOldMethodName($node);
        if ($oldNodeMethodName === null) {
            return;
        }
        $node->name = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier($renameMethodMap[$oldNodeMethodName]);
    }
    /**
     * @param ClassConstFetch|MethodCall|PropertyFetch|StaticCall|ClassMethod $node
     */
    public function removeSuffix(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, string $suffixToRemove) : void
    {
        $this->ensureNodeHasIdentifier($node);
        $name = $this->nodeNameResolver->getName($node);
        if ($name === null) {
            return;
        }
        $newName = \_PhpScoper0a2ac50786fa\Nette\Utils\Strings::replace($name, \sprintf('#%s$#', $suffixToRemove), '');
        $node->name = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier($newName);
    }
    private function ensureNodeHasIdentifier(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : void
    {
        if (\in_array(\get_class($node), self::NODE_CLASSES_WITH_IDENTIFIER, \true)) {
            return;
        }
        throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\NodeChanger\NodeMissingIdentifierException(\sprintf('Node "%s" does not contain a "$name" property with "%s". Pass only one of "%s".', \get_class($node), \_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier::class, \implode('", "', self::NODE_CLASSES_WITH_IDENTIFIER)));
    }
    private function resolveOldMethodName(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?string
    {
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall || $node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall) {
            return $this->nodeNameResolver->getName($node->name);
        }
        return $this->nodeNameResolver->getName($node);
    }
}
