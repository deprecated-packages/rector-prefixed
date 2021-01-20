<?php

declare (strict_types=1);
namespace Rector\Generic\Rector\Property;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\Property;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\Visibility;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Generic\Tests\Rector\Property\ChangePropertyVisibilityRector\ChangePropertyVisibilityRectorTest
 */
final class ChangePropertyVisibilityRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const PROPERTY_TO_VISIBILITY_BY_CLASS = 'property_to_visibility_by_class';
    /**
     * @var array<string, array<string, int>>
     */
    private $propertyToVisibilityByClass = [];
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change visibility of property from parent class.', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
class FrameworkClass
{
    protected $someProperty;
}

class MyClass extends FrameworkClass
{
    public $someProperty;
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class FrameworkClass
{
    protected $someProperty;
}

class MyClass extends FrameworkClass
{
    protected $someProperty;
}
CODE_SAMPLE
, [self::PROPERTY_TO_VISIBILITY_BY_CLASS => ['FrameworkClass' => ['someProperty' => \Rector\Core\ValueObject\Visibility::PROTECTED]]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\Property::class];
    }
    /**
     * @param Property $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        foreach ($this->propertyToVisibilityByClass as $type => $propertyToVisibility) {
            $classNode = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
            if (!$classNode instanceof \PhpParser\Node\Stmt\ClassLike) {
                continue;
            }
            if (!$this->isObjectType($classNode, $type)) {
                continue;
            }
            foreach ($propertyToVisibility as $property => $visibility) {
                if (!$this->isName($node, $property)) {
                    continue;
                }
                $this->changeNodeVisibility($node, $visibility);
                return $node;
            }
        }
        return null;
    }
    public function configure(array $configuration) : void
    {
        $this->propertyToVisibilityByClass = $configuration[self::PROPERTY_TO_VISIBILITY_BY_CLASS] ?? [];
    }
}
