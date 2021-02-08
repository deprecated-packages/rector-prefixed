<?php

declare (strict_types=1);
namespace Rector\Core\Rector\AbstractRector;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use Rector\ChangesReporting\Rector\AbstractRector\NotifyingRemovingNodeTrait;
use Rector\CodingStyle\Naming\ClassNaming;
use Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\NodeTypeResolver;
use Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper;
use Rector\PostRector\Rector\AbstractRector\NodeCommandersTrait;
use RectorPrefix20210208\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser;
trait AbstractRectorTrait
{
    use RemovedAndAddedFilesTrait;
    use NodeCommandersTrait;
    use NotifyingRemovingNodeTrait;
    /**
     * @var NodeNameResolver
     */
    protected $nodeNameResolver;
    /**
     * @var TypeUnwrapper
     */
    protected $typeUnwrapper;
    /**
     * @var NodeTypeResolver
     */
    protected $nodeTypeResolver;
    /**
     * @var BetterStandardPrinter
     */
    protected $betterStandardPrinter;
    /**
     * @var ClassNaming
     */
    private $classNaming;
    /**
     * @var SimpleCallableNodeTraverser
     */
    private $simpleCallableNodeTraverser;
    /**
     * @required
     */
    public function autowireAbstractRectorTrait(\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\CodingStyle\Naming\ClassNaming $classNaming, \Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper $typeUnwrapper, \RectorPrefix20210208\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser $simpleCallableNodeTraverser) : void
    {
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->classNaming = $classNaming;
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->typeUnwrapper = $typeUnwrapper;
        $this->simpleCallableNodeTraverser = $simpleCallableNodeTraverser;
    }
    protected function isName(\PhpParser\Node $node, string $name) : bool
    {
        return $this->nodeNameResolver->isName($node, $name);
    }
    protected function areNamesEqual(\PhpParser\Node $firstNode, \PhpParser\Node $secondNode) : bool
    {
        return $this->nodeNameResolver->areNamesEqual($firstNode, $secondNode);
    }
    /**
     * @param string[] $names
     */
    protected function isNames(\PhpParser\Node $node, array $names) : bool
    {
        return $this->nodeNameResolver->isNames($node, $names);
    }
    protected function getName(\PhpParser\Node $node) : ?string
    {
        return $this->nodeNameResolver->getName($node);
    }
    /**
     * @param string|Name|Identifier|ClassLike $name
     */
    protected function getShortName($name) : string
    {
        return $this->classNaming->getShortName($name);
    }
    protected function isLocalPropertyFetchNamed(\PhpParser\Node $node, string $name) : bool
    {
        return $this->nodeNameResolver->isLocalPropertyFetchNamed($node, $name);
    }
    protected function isLocalMethodCallNamed(\PhpParser\Node $node, string $name) : bool
    {
        return $this->nodeNameResolver->isLocalMethodCallNamed($node, $name);
    }
    /**
     * @param string[] $names
     */
    protected function isLocalMethodCallsNamed(\PhpParser\Node $node, array $names) : bool
    {
        return $this->nodeNameResolver->isLocalMethodCallsNamed($node, $names);
    }
    protected function isFuncCallName(\PhpParser\Node $node, string $name) : bool
    {
        return $this->nodeNameResolver->isFuncCallName($node, $name);
    }
    /**
     * Detects "SomeClass::class"
     */
    protected function isClassConstReference(\PhpParser\Node $node, string $className) : bool
    {
        if (!$node instanceof \PhpParser\Node\Expr\ClassConstFetch) {
            return \false;
        }
        if (!$this->isName($node->name, 'class')) {
            return \false;
        }
        return $this->isName($node->class, $className);
    }
    protected function isStaticCallNamed(\PhpParser\Node $node, string $className, string $methodName) : bool
    {
        if (!$node instanceof \PhpParser\Node\Expr\StaticCall) {
            return \false;
        }
        // handles (new Some())->...
        if ($node->class instanceof \PhpParser\Node\Expr) {
            if (!$this->isObjectType($node->class, $className)) {
                return \false;
            }
        } elseif (!$this->isName($node->class, $className)) {
            return \false;
        }
        return $this->isName($node->name, $methodName);
    }
    /**
     * @param string[] $names
     */
    protected function isFuncCallNames(\PhpParser\Node $node, array $names) : bool
    {
        return $this->nodeNameResolver->isFuncCallNames($node, $names);
    }
    /**
     * @param string[] $methodNames
     */
    protected function isStaticCallsNamed(\PhpParser\Node $node, string $className, array $methodNames) : bool
    {
        foreach ($methodNames as $methodName) {
            if ($this->isStaticCallNamed($node, $className, $methodName)) {
                return \true;
            }
        }
        return \false;
    }
    protected function isMethodCall(\PhpParser\Node $node, string $variableName, string $methodName) : bool
    {
        if (!$node instanceof \PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        if ($node->var instanceof \PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        if ($node->var instanceof \PhpParser\Node\Expr\StaticCall) {
            return \false;
        }
        if (!$this->isName($node->var, $variableName)) {
            return \false;
        }
        return $this->isName($node->name, $methodName);
    }
    protected function isVariableName(\PhpParser\Node $node, string $name) : bool
    {
        if (!$node instanceof \PhpParser\Node\Expr\Variable) {
            return \false;
        }
        return $this->isName($node, $name);
    }
    protected function isInClassNamed(\PhpParser\Node $node, string $desiredClassName) : bool
    {
        $className = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className === null) {
            return \false;
        }
        return \is_a($className, $desiredClassName, \true);
    }
    /**
     * @param string[] $desiredClassNames
     */
    protected function isInClassesNamed(\PhpParser\Node $node, array $desiredClassNames) : bool
    {
        foreach ($desiredClassNames as $desiredClassName) {
            if ($this->isInClassNamed($node, $desiredClassName)) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @param ObjectType|string $type
     */
    protected function isObjectType(\PhpParser\Node $node, $type) : bool
    {
        return $this->nodeTypeResolver->isObjectType($node, $type);
    }
    /**
     * @param string[]|ObjectType[] $requiredTypes
     */
    protected function isObjectTypes(\PhpParser\Node $node, array $requiredTypes) : bool
    {
        return $this->nodeTypeResolver->isObjectTypes($node, $requiredTypes);
    }
    /**
     * @param Type[] $desiredTypes
     */
    protected function isSameObjectTypes(\PHPStan\Type\ObjectType $objectType, array $desiredTypes) : bool
    {
        foreach ($desiredTypes as $abstractClassConstructorParamType) {
            if ($abstractClassConstructorParamType->equals($objectType)) {
                return \true;
            }
        }
        return \false;
    }
    protected function isNumberType(\PhpParser\Node $node) : bool
    {
        return $this->nodeTypeResolver->isNumberType($node);
    }
    protected function isStaticType(\PhpParser\Node $node, string $staticTypeClass) : bool
    {
        return $this->nodeTypeResolver->isStaticType($node, $staticTypeClass);
    }
    protected function getStaticType(\PhpParser\Node $node) : \PHPStan\Type\Type
    {
        return $this->nodeTypeResolver->getStaticType($node);
    }
    protected function isNullableType(\PhpParser\Node $node) : bool
    {
        return $this->nodeTypeResolver->isNullableType($node);
    }
    protected function getObjectType(\PhpParser\Node $node) : \PHPStan\Type\Type
    {
        return $this->nodeTypeResolver->resolve($node);
    }
    /**
     * @param MethodCall|StaticCall|ClassMethod $node
     */
    protected function isMethodStaticCallOrClassMethodObjectType(\PhpParser\Node $node, string $type) : bool
    {
        if ($node instanceof \PhpParser\Node\Expr\MethodCall) {
            // method call is variable return
            return $this->isObjectType($node->var, $type);
        }
        if ($node instanceof \PhpParser\Node\Expr\StaticCall) {
            return $this->isObjectType($node->class, $type);
        }
        $classLike = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \PhpParser\Node\Stmt\Class_) {
            return \false;
        }
        return $this->isObjectType($classLike, $type);
    }
    /**
     * @param Node|Node[] $nodes
     */
    protected function traverseNodesWithCallable($nodes, callable $callable) : void
    {
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable($nodes, $callable);
    }
    /**
     * @param Node|Node[]|null $node
     */
    protected function print($node) : string
    {
        return $this->betterStandardPrinter->print($node);
    }
    /**
     * Removes all comments from both nodes
     *
     * @param Node|Node[]|null $firstNode
     * @param Node|Node[]|null $secondNode
     */
    protected function areNodesEqual($firstNode, $secondNode) : bool
    {
        return $this->betterStandardPrinter->areNodesEqual($firstNode, $secondNode);
    }
}
