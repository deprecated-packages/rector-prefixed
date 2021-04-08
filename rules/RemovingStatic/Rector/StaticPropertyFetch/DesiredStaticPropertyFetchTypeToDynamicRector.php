<?php

declare (strict_types=1);
namespace Rector\RemovingStatic\Rector\StaticPropertyFetch;

use PhpParser\Node;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\StaticPropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Type\ObjectType;
use Rector\Core\Configuration\Option;
use Rector\Core\Rector\AbstractRector;
use Rector\Naming\Naming\PropertyNaming;
use Rector\NodeTypeResolver\Node\AttributeKey;
use RectorPrefix20210408\Symplify\PackageBuilder\Parameter\ParameterProvider;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Tests\RemovingStatic\Rector\StaticPropertyFetch\DesiredStaticPropertyFetchTypeToDynamicRector\DesiredStaticPropertyFetchTypeToDynamicRectorTest
 */
final class DesiredStaticPropertyFetchTypeToDynamicRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var ObjectType[]
     */
    private $staticObjectTypes = [];
    /**
     * @var PropertyNaming
     */
    private $propertyNaming;
    public function __construct(\Rector\Naming\Naming\PropertyNaming $propertyNaming, \RectorPrefix20210408\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider)
    {
        $typesToRemoveStaticFrom = $parameterProvider->provideArrayParameter(\Rector\Core\Configuration\Option::TYPES_TO_REMOVE_STATIC_FROM);
        foreach ($typesToRemoveStaticFrom as $typeToRemoveStaticFrom) {
            $this->staticObjectTypes[] = new \PHPStan\Type\ObjectType($typeToRemoveStaticFrom);
        }
        $this->propertyNaming = $propertyNaming;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change defined static service to dynamic one', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    public function run()
    {
        SomeStaticMethod::$someStatic;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    public function run()
    {
        $this->someStaticMethod::$someStatic;
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\StaticPropertyFetch::class];
    }
    /**
     * @param StaticPropertyFetch $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        /** @var Scope $scope */
        $scope = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        $classReflection = $scope->getClassReflection();
        if (!$classReflection instanceof \PHPStan\Reflection\ClassReflection) {
            return null;
        }
        $classObjectType = new \PHPStan\Type\ObjectType($classReflection->getName());
        // A. remove local fetch
        foreach ($this->staticObjectTypes as $staticObjectType) {
            if (!$staticObjectType->isSuperTypeOf($classObjectType)->yes()) {
                continue;
            }
            return new \PhpParser\Node\Expr\PropertyFetch(new \PhpParser\Node\Expr\Variable('this'), $node->name);
        }
        // B. external property fetch
        foreach ($this->staticObjectTypes as $staticObjectType) {
            if (!$this->isObjectType($node->class, $staticObjectType)) {
                continue;
            }
            $propertyName = $this->propertyNaming->fqnToVariableName($staticObjectType);
            /** @var Class_ $class */
            $class = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
            $this->addConstructorDependencyToClass($class, $staticObjectType, $propertyName);
            $objectPropertyFetch = new \PhpParser\Node\Expr\PropertyFetch(new \PhpParser\Node\Expr\Variable('this'), $propertyName);
            return new \PhpParser\Node\Expr\PropertyFetch($objectPropertyFetch, $node->name);
        }
        return null;
    }
}
