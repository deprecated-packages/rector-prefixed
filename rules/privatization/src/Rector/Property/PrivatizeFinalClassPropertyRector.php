<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Privatization\Rector\Property;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Privatization\Tests\Rector\Property\PrivatizeFinalClassPropertyRector\PrivatizeFinalClassPropertyRectorTest
 */
final class PrivatizeFinalClassPropertyRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change property to private if possible', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    protected $value;
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    private $value;
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property::class];
    }
    /**
     * @param Property $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $classLike = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_) {
            return null;
        }
        if (!$classLike->isFinal()) {
            return null;
        }
        if ($this->shouldSkipProperty($node)) {
            return null;
        }
        if ($classLike->extends === null) {
            $this->makePrivate($node);
            return $node;
        }
        if ($this->isPropertyVisibilityGuardedByParent($node, $classLike)) {
            return null;
        }
        $this->makePrivate($node);
        return $node;
    }
    private function shouldSkipProperty(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property) : bool
    {
        if (\count((array) $property->props) !== 1) {
            return \true;
        }
        return !$property->isProtected();
    }
    private function isPropertyVisibilityGuardedByParent(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        if ($class->extends === null) {
            return \false;
        }
        $parentClasses = $this->getParentClasses($class);
        $propertyName = $this->getName($property);
        foreach ($parentClasses as $parentClass) {
            if (\property_exists($parentClass, $propertyName)) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @return class-string[]
     */
    private function getParentClasses(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : array
    {
        /** @var string $className */
        $className = $this->getName($class);
        /** @var class-string[] $parents */
        $parents = (array) \class_parents($className);
        return $parents;
    }
}
