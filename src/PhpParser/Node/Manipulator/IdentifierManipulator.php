<?php

declare (strict_types=1);
namespace Rector\Core\PhpParser\Node\Manipulator;

use RectorPrefix20210118\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\Core\Exception\NodeChanger\NodeMissingIdentifierException;
use Rector\Core\Util\StaticInstanceOf;
use Rector\NodeNameResolver\NodeNameResolver;
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
    private const NODE_CLASSES_WITH_IDENTIFIER = [\PhpParser\Node\Expr\ClassConstFetch::class, \PhpParser\Node\Expr\MethodCall::class, \PhpParser\Node\Expr\PropertyFetch::class, \PhpParser\Node\Expr\StaticCall::class, \PhpParser\Node\Stmt\ClassMethod::class];
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @param ClassConstFetch|MethodCall|PropertyFetch|StaticCall|ClassMethod $node
     * @param string[] $renameMethodMap
     */
    public function renameNodeWithMap(\PhpParser\Node $node, array $renameMethodMap) : void
    {
        $this->ensureNodeHasIdentifier($node);
        $oldNodeMethodName = $this->resolveOldMethodName($node);
        if ($oldNodeMethodName === null) {
            return;
        }
        $node->name = new \PhpParser\Node\Identifier($renameMethodMap[$oldNodeMethodName]);
    }
    /**
     * @param ClassConstFetch|MethodCall|PropertyFetch|StaticCall|ClassMethod $node
     */
    public function removeSuffix(\PhpParser\Node $node, string $suffixToRemove) : void
    {
        $this->ensureNodeHasIdentifier($node);
        $name = $this->nodeNameResolver->getName($node);
        if ($name === null) {
            return;
        }
        $newName = \RectorPrefix20210118\Nette\Utils\Strings::replace($name, \sprintf('#%s$#', $suffixToRemove), '');
        $node->name = new \PhpParser\Node\Identifier($newName);
    }
    private function ensureNodeHasIdentifier(\PhpParser\Node $node) : void
    {
        if (\in_array(\get_class($node), self::NODE_CLASSES_WITH_IDENTIFIER, \true)) {
            return;
        }
        throw new \Rector\Core\Exception\NodeChanger\NodeMissingIdentifierException(\sprintf('Node "%s" does not contain a "$name" property with "%s". Pass only one of "%s".', \get_class($node), \PhpParser\Node\Identifier::class, \implode('", "', self::NODE_CLASSES_WITH_IDENTIFIER)));
    }
    private function resolveOldMethodName(\PhpParser\Node $node) : ?string
    {
        if (!\property_exists($node, 'name')) {
            return $this->nodeNameResolver->getName($node);
        }
        if (\Rector\Core\Util\StaticInstanceOf::isOneOf($node, [\PhpParser\Node\Expr\StaticCall::class, \PhpParser\Node\Expr\MethodCall::class])) {
            return $this->nodeNameResolver->getName($node->name);
        }
        return null;
    }
}
