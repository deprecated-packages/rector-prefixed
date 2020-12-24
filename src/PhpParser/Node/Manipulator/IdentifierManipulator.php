<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\Rector\Core\Exception\NodeChanger\NodeMissingIdentifierException;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
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
    private const NODE_CLASSES_WITH_IDENTIFIER = [\_PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class];
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @param ClassConstFetch|MethodCall|PropertyFetch|StaticCall|ClassMethod $node
     * @param string[] $renameMethodMap
     */
    public function renameNodeWithMap(\_PhpScopere8e811afab72\PhpParser\Node $node, array $renameMethodMap) : void
    {
        $this->ensureNodeHasIdentifier($node);
        $oldNodeMethodName = $this->resolveOldMethodName($node);
        if ($oldNodeMethodName === null) {
            return;
        }
        $node->name = new \_PhpScopere8e811afab72\PhpParser\Node\Identifier($renameMethodMap[$oldNodeMethodName]);
    }
    /**
     * @param ClassConstFetch|MethodCall|PropertyFetch|StaticCall|ClassMethod $node
     */
    public function removeSuffix(\_PhpScopere8e811afab72\PhpParser\Node $node, string $suffixToRemove) : void
    {
        $this->ensureNodeHasIdentifier($node);
        $name = $this->nodeNameResolver->getName($node);
        if ($name === null) {
            return;
        }
        $newName = \_PhpScopere8e811afab72\Nette\Utils\Strings::replace($name, \sprintf('#%s$#', $suffixToRemove), '');
        $node->name = new \_PhpScopere8e811afab72\PhpParser\Node\Identifier($newName);
    }
    private function ensureNodeHasIdentifier(\_PhpScopere8e811afab72\PhpParser\Node $node) : void
    {
        if (\in_array(\get_class($node), self::NODE_CLASSES_WITH_IDENTIFIER, \true)) {
            return;
        }
        throw new \_PhpScopere8e811afab72\Rector\Core\Exception\NodeChanger\NodeMissingIdentifierException(\sprintf('Node "%s" does not contain a "$name" property with "%s". Pass only one of "%s".', \get_class($node), \_PhpScopere8e811afab72\PhpParser\Node\Identifier::class, \implode('", "', self::NODE_CLASSES_WITH_IDENTIFIER)));
    }
    private function resolveOldMethodName(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?string
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall || $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
            return $this->nodeNameResolver->getName($node->name);
        }
        return $this->nodeNameResolver->getName($node);
    }
}
