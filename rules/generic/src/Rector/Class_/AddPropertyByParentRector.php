<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Rector\Class_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\AddPropertyByParent;
use _PhpScopere8e811afab72\Rector\Naming\Naming\PropertyNaming;
use _PhpScopere8e811afab72\Rector\Naming\ValueObject\ExpectedName;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScopere8e811afab72\Webmozart\Assert\Assert;
/**
 * @see \Rector\Generic\Tests\Rector\Class_\AddPropertyByParentRector\AddPropertyByParentRectorTest
 */
final class AddPropertyByParentRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
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
    public function __construct(\_PhpScopere8e811afab72\Rector\Naming\Naming\PropertyNaming $propertyNaming)
    {
        $this->propertyNaming = $propertyNaming;
    }
    /**
     * @return class-string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_::class];
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Add dependency via constructor by parent class type', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($node->extends === null) {
            return null;
        }
        $currentParentClassName = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_CLASS_NAME);
        foreach ($this->parentDependencies as $parentDependency) {
            if ($currentParentClassName !== $parentDependency->getParentClass()) {
                continue;
            }
            $propertyType = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($parentDependency->getDependencyType());
            /** @var ExpectedName $propertyName */
            $propertyName = $this->propertyNaming->getExpectedNameFromType($propertyType);
            $this->addConstructorDependencyToClass($node, $propertyType, $propertyName->getName());
        }
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $parentDependencies = $configuration[self::PARENT_DEPENDENCIES] ?? [];
        \_PhpScopere8e811afab72\Webmozart\Assert\Assert::allIsInstanceOf($parentDependencies, \_PhpScopere8e811afab72\Rector\Generic\ValueObject\AddPropertyByParent::class);
        $this->parentDependencies = $parentDependencies;
    }
}
