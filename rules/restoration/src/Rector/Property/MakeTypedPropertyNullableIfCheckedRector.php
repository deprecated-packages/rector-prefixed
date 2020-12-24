<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Restoration\Rector\Property;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\NullableType;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\PropertyProperty;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Restoration\Tests\Rector\Property\MakeTypedPropertyNullableIfCheckedRector\MakeTypedPropertyNullableIfCheckedRectorTest
 */
final class MakeTypedPropertyNullableIfCheckedRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Make typed property nullable if checked', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    private AnotherClass $anotherClass;

    public function run()
    {
        if ($this->anotherClass === null) {
            $this->anotherClass = new AnotherClass;
        }
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    private ?AnotherClass $anotherClass = null;

    public function run()
    {
        if ($this->anotherClass === null) {
            $this->anotherClass = new AnotherClass;
        }
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property::class];
    }
    /**
     * @param Property $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ($this->shouldSkipProperty($node)) {
            return null;
        }
        /** @var PropertyProperty $onlyProperty */
        $onlyProperty = $node->props[0];
        $isPropretyNullChecked = $this->isPropertyNullChecked($onlyProperty);
        if (!$isPropretyNullChecked) {
            return null;
        }
        $currentPropertyType = $node->type;
        if ($currentPropertyType === null) {
            return null;
        }
        $node->type = new \_PhpScoperb75b35f52b74\PhpParser\Node\NullableType($currentPropertyType);
        $onlyProperty->default = $this->createNull();
        return $node;
    }
    private function shouldSkipProperty(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property) : bool
    {
        if (\count((array) $property->props) !== 1) {
            return \true;
        }
        if ($property->type === null) {
            return \true;
        }
        return $property->type instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\NullableType;
    }
    private function isPropertyNullChecked(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\PropertyProperty $onlyPropertyProperty) : bool
    {
        $classLike = $onlyPropertyProperty->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_) {
            return \false;
        }
        if ($this->isIdenticalOrNotIdenticalToNull($classLike, $onlyPropertyProperty)) {
            return \true;
        }
        return $this->isBooleanNot($classLike, $onlyPropertyProperty);
    }
    private function isIdenticalOrNotIdenticalToNull(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\PropertyProperty $onlyPropertyProperty) : bool
    {
        $isIdenticalOrNotIdenticalToNull = \false;
        $this->traverseNodesWithCallable((array) $class->stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use($onlyPropertyProperty, &$isIdenticalOrNotIdenticalToNull) {
            $matchedPropertyFetchName = $this->matchPropertyFetchNameComparedToNull($node);
            if ($matchedPropertyFetchName === null) {
                return null;
            }
            if (!$this->isName($onlyPropertyProperty, $matchedPropertyFetchName)) {
                return null;
            }
            $isIdenticalOrNotIdenticalToNull = \true;
        });
        return $isIdenticalOrNotIdenticalToNull;
    }
    private function isBooleanNot(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\PropertyProperty $onlyPropertyProperty) : bool
    {
        $isBooleanNot = \false;
        $this->traverseNodesWithCallable((array) $class->stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use($onlyPropertyProperty, &$isBooleanNot) {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot) {
                return null;
            }
            if (!$node->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch) {
                return null;
            }
            if (!$this->isName($node->expr->var, 'this')) {
                return null;
            }
            $propertyFetchName = $this->getName($node->expr->name);
            if (!$this->isName($onlyPropertyProperty, $propertyFetchName)) {
                return null;
            }
            $isBooleanNot = \true;
        });
        return $isBooleanNot;
    }
    /**
     * Matches:
     * $this-><someProprety> === null
     * null === $this-><someProprety>
     */
    private function matchPropertyFetchNameComparedToNull(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?string
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical && !$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotIdentical) {
            return null;
        }
        if ($node->left instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch && $this->isNull($node->right)) {
            $propertyFetch = $node->left;
        } elseif ($node->right instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch && $this->isNull($node->left)) {
            $propertyFetch = $node->right;
        } else {
            return null;
        }
        if (!$this->isName($propertyFetch->var, 'this')) {
            return null;
        }
        return $this->getName($propertyFetch->name);
    }
}
