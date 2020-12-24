<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodeQuality\Rector\FunctionLike;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Closure;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\If_;
use _PhpScopere8e811afab72\PhpParser\NodeTraverser;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\NullType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\Type\StaticTypeAnalyzer;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://phpstan.org/r/e909844a-084e-427e-92ac-fed3c2aeabab
 *
 * @see \Rector\CodeQuality\Tests\Rector\FunctionLike\RemoveAlwaysTrueConditionSetInConstructorRector\RemoveAlwaysTrueConditionSetInConstructorRectorTest
 */
final class RemoveAlwaysTrueConditionSetInConstructorRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var StaticTypeAnalyzer
     */
    private $staticTypeAnalyzer;
    /**
     * @var TypeFactory
     */
    private $typeFactory;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\Type\StaticTypeAnalyzer $staticTypeAnalyzer, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory)
    {
        $this->staticTypeAnalyzer = $staticTypeAnalyzer;
        $this->typeFactory = $typeFactory;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('If conditions is always true, perform the content right away', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function go()
    {
        if ($this->value) {
            return 'yes';
        }
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function go()
    {
        return 'yes';
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\Closure::class];
    }
    /**
     * @param ClassMethod|Closure $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($node->stmts === null || $node->stmts === []) {
            return null;
        }
        $haveNodeChanged = \false;
        foreach ((array) $node->stmts as $key => $stmt) {
            if ($stmt instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression) {
                $stmt = $stmt->expr;
            }
            if (!$this->isAlwaysTruableNode($stmt)) {
                continue;
            }
            /** @var If_ $stmt */
            if (\count((array) $stmt->stmts) === 1) {
                $node->stmts[$key] = $stmt->stmts[0];
                continue;
            }
            $haveNodeChanged = \true;
            // move all nodes one level up
            \array_splice($node->stmts, $key, \count((array) $stmt->stmts) - 1, $stmt->stmts);
        }
        if ($haveNodeChanged) {
            return $node;
        }
        return null;
    }
    private function isAlwaysTruableNode(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\If_) {
            return \false;
        }
        // just one if
        if (\count((array) $node->elseifs) !== 0) {
            return \false;
        }
        // there is some else
        if ($node->else !== null) {
            return \false;
        }
        // only property fetch, because of constructor set
        if (!$node->cond instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch) {
            return \false;
        }
        $propertyFetchType = $this->resolvePropertyFetchType($node->cond);
        return $this->staticTypeAnalyzer->isAlwaysTruableType($propertyFetchType);
    }
    private function resolvePropertyFetchType(\_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch $propertyFetch) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $classLike = $propertyFetch->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        $propertyName = $this->getName($propertyFetch);
        if ($propertyName === null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        $property = $classLike->getProperty($propertyName);
        if ($property === null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        // anything but private can be changed from outer scope
        if (!$property->isPrivate()) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        // set in constructor + changed in class
        $propertyTypeFromConstructor = $this->resolvePropertyTypeAfterConstructor($classLike, $propertyName);
        $resolvedTypes = [];
        $resolvedTypes[] = $propertyTypeFromConstructor;
        $defaultValue = $property->props[0]->default;
        if ($defaultValue !== null) {
            $resolvedTypes[] = $this->getStaticType($defaultValue);
        }
        $resolveAssignedType = $this->resolveAssignedTypeInStmtsByPropertyName($classLike->stmts, $propertyName);
        if ($resolveAssignedType !== null) {
            $resolvedTypes[] = $resolveAssignedType;
        }
        return $this->typeFactory->createMixedPassedOrUnionTypeAndKeepConstant($resolvedTypes);
    }
    private function resolvePropertyTypeAfterConstructor(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class, string $propertyName) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $propertyTypeFromConstructor = null;
        $constructClassMethod = $class->getMethod(\_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if ($constructClassMethod !== null) {
            $propertyTypeFromConstructor = $this->resolveAssignedTypeInStmtsByPropertyName((array) $constructClassMethod->stmts, $propertyName);
        }
        if ($propertyTypeFromConstructor !== null) {
            return $propertyTypeFromConstructor;
        }
        // undefined property is null by default
        return new \_PhpScopere8e811afab72\PHPStan\Type\NullType();
    }
    /**
     * @param Stmt[] $stmts
     */
    private function resolveAssignedTypeInStmtsByPropertyName(array $stmts, string $propertyName) : ?\_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $resolvedTypes = [];
        $this->traverseNodesWithCallable($stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($propertyName, &$resolvedTypes) : ?int {
            if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod && $this->isName($node, \_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::CONSTRUCT)) {
                return \_PhpScopere8e811afab72\PhpParser\NodeTraverser::DONT_TRAVERSE_CHILDREN;
            }
            if (!$this->isPropertyFetchAssignOfPropertyName($node, $propertyName)) {
                return null;
            }
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
                return null;
            }
            $resolvedTypes[] = $this->getStaticType($node->expr);
            return null;
        });
        if ($resolvedTypes === []) {
            return null;
        }
        return $this->typeFactory->createMixedPassedOrUnionTypeAndKeepConstant($resolvedTypes);
    }
    /**
     * E.g. $this->{value} = x
     */
    private function isPropertyFetchAssignOfPropertyName(\_PhpScopere8e811afab72\PhpParser\Node $node, string $propertyName) : bool
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
            return \false;
        }
        if (!$node->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch) {
            return \false;
        }
        return $this->isName($node->var, $propertyName);
    }
}
