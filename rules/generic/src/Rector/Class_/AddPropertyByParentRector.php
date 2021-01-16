<?php

declare (strict_types=1);
namespace Rector\Generic\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Type\ObjectType;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Rector\Generic\ValueObject\AddPropertyByParent;
use Rector\Naming\Naming\PropertyNaming;
use Rector\Naming\ValueObject\ExpectedName;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use RectorPrefix20210116\Webmozart\Assert\Assert;
/**
 * @see \Rector\Generic\Tests\Rector\Class_\AddPropertyByParentRector\AddPropertyByParentRectorTest
 */
final class AddPropertyByParentRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @api
     * @var string
     */
    public const PARENT_DEPENDENCIES = 'parent_dependencies';
    /**
     * @var AddPropertyByParent[]
     */
    private $parentDependencies = [];
    /**
     * @var PropertyNaming
     */
    private $propertyNaming;
    public function __construct(\Rector\Naming\Naming\PropertyNaming $propertyNaming)
    {
        $this->propertyNaming = $propertyNaming;
    }
    /**
     * @return class-string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\Class_::class];
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Add dependency via constructor by parent class type', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
final class SomeClass extends SomeParentClass
{
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass extends SomeParentClass
{
    /**
     * @var SomeDependency
     */
    private $someDependency;

    public function __construct(SomeDependency $someDependency)
    {
        $this->someDependency = $someDependency;
    }
}
CODE_SAMPLE
, [self::PARENT_DEPENDENCIES => ['SomeParentClass' => ['SomeDependency']]])]);
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($node->extends === null) {
            return null;
        }
        $currentParentClassName = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_CLASS_NAME);
        foreach ($this->parentDependencies as $parentDependency) {
            if ($currentParentClassName !== $parentDependency->getParentClass()) {
                continue;
            }
            $propertyType = new \PHPStan\Type\ObjectType($parentDependency->getDependencyType());
            /** @var ExpectedName $propertyName */
            $propertyName = $this->propertyNaming->getExpectedNameFromType($propertyType);
            $this->addConstructorDependencyToClass($node, $propertyType, $propertyName->getName());
        }
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $parentDependencies = $configuration[self::PARENT_DEPENDENCIES] ?? [];
        \RectorPrefix20210116\Webmozart\Assert\Assert::allIsInstanceOf($parentDependencies, \Rector\Generic\ValueObject\AddPropertyByParent::class);
        $this->parentDependencies = $parentDependencies;
    }
}
