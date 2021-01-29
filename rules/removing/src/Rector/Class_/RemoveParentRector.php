<?php

declare (strict_types=1);
namespace Rector\Removing\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Removing\Tests\Rector\Class_\RemoveParentRector\RemoveParentRectorTest
 */
final class RemoveParentRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @api
     * @var string
     */
    public const PARENT_TYPES_TO_REMOVE = 'parents_types_to_remove';
    /**
     * @var string[]
     */
    private $parentClassesToRemove = [];
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Removes extends class by name', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
final class SomeClass extends SomeParentClass
{
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
}
CODE_SAMPLE
, [self::PARENT_TYPES_TO_REMOVE => ['SomeParentClass']])]);
    }
    /**
     * @return class-string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($node->extends === null) {
            return null;
        }
        foreach ($this->parentClassesToRemove as $parentClassToRemove) {
            $parentClassName = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_CLASS_NAME);
            if ($parentClassName !== $parentClassToRemove) {
                continue;
            }
            // remove parent class
            $node->extends = null;
            return $node;
        }
        return null;
    }
    public function configure(array $configuration) : void
    {
        $this->parentClassesToRemove = $configuration[self::PARENT_TYPES_TO_REMOVE] ?? [];
    }
}
