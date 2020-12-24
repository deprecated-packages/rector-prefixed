<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DowngradePhp80\Rector\Class_;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://wiki.php.net/rfc/constructor_promotion
 *
 * @see \Rector\DowngradePhp80\Tests\Rector\Class_\DowngradePropertyPromotionToConstructorPropertyAssignRector\DowngradePropertyPromotionToConstructorPropertyAssignRectorTest
 */
final class DowngradePropertyPromotionToConstructorPropertyAssignRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ClassInsertManipulator
     */
    private $classInsertManipulator;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator $classInsertManipulator)
    {
        $this->classInsertManipulator = $classInsertManipulator;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change constructor property promotion to property asssign', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function __construct(public float $value = 0.0)
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public float $value;

    public function __construct(float $value = 0.0)
    {
        $this->value = $value;
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $promotedParams = $this->resolvePromotedParams($node);
        if ($promotedParams === []) {
            return null;
        }
        $properties = $this->addPropertiesFromParams($promotedParams, $node);
        $this->addPropertyAssignsToConstructorClassMethod($properties, $node);
        foreach ($promotedParams as $promotedParam) {
            $promotedParam->flags = 0;
        }
        return $node;
    }
    /**
     * @return Param[]
     */
    private function resolvePromotedParams(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $constructorClassMethod = $class->getMethod(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if ($constructorClassMethod === null) {
            return [];
        }
        $promotedParams = [];
        foreach ($constructorClassMethod->params as $param) {
            if ($param->flags === 0) {
                continue;
            }
            $promotedParams[] = $param;
        }
        return $promotedParams;
    }
    /**
     * @param Param[] $promotedParams
     * @return Property[]
     */
    private function addPropertiesFromParams(array $promotedParams, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $properties = $this->createPropertiesFromParams($promotedParams);
        $this->classInsertManipulator->addPropertiesToClass($class, $properties);
        return $properties;
    }
    /**
     * @param Property[] $properties
     */
    private function addPropertyAssignsToConstructorClassMethod(array $properties, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $assigns = [];
        foreach ($properties as $property) {
            $propertyName = $this->getName($property);
            $assign = $this->nodeFactory->createPropertyAssignment($propertyName);
            $assigns[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression($assign);
        }
        /** @var ClassMethod $constructorClassMethod */
        $constructorClassMethod = $class->getMethod(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        $constructorClassMethod->stmts = \array_merge($assigns, (array) $constructorClassMethod->stmts);
    }
    /**
     * @param Param[] $params
     * @return Property[]
     */
    private function createPropertiesFromParams(array $params) : array
    {
        $properties = [];
        foreach ($params as $param) {
            /** @var string $name */
            $name = $this->getName($param->var);
            $property = $this->nodeFactory->createProperty($name);
            $property->flags = $param->flags;
            $property->type = $param->type;
            $properties[] = $property;
        }
        return $properties;
    }
}
