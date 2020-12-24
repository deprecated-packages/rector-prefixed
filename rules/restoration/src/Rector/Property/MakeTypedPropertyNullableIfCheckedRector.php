<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Restoration\Rector\Property;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BooleanNot;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\NullableType;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\PropertyProperty;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Restoration\Tests\Rector\Property\MakeTypedPropertyNullableIfCheckedRector\MakeTypedPropertyNullableIfCheckedRectorTest
 */
final class MakeTypedPropertyNullableIfCheckedRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Make typed property nullable if checked', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property::class];
    }
    /**
     * @param Property $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
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
        $node->type = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\NullableType($currentPropertyType);
        $onlyProperty->default = $this->createNull();
        return $node;
    }
    private function shouldSkipProperty(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property $property) : bool
    {
        if (\count((array) $property->props) !== 1) {
            return \true;
        }
        if ($property->type === null) {
            return \true;
        }
        return $property->type instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\NullableType;
    }
    private function isPropertyNullChecked(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\PropertyProperty $onlyPropertyProperty) : bool
    {
        $classLike = $onlyPropertyProperty->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_) {
            return \false;
        }
        if ($this->isIdenticalOrNotIdenticalToNull($classLike, $onlyPropertyProperty)) {
            return \true;
        }
        return $this->isBooleanNot($classLike, $onlyPropertyProperty);
    }
    private function isIdenticalOrNotIdenticalToNull(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ $class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\PropertyProperty $onlyPropertyProperty) : bool
    {
        $isIdenticalOrNotIdenticalToNull = \false;
        $this->traverseNodesWithCallable((array) $class->stmts, function (\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) use($onlyPropertyProperty, &$isIdenticalOrNotIdenticalToNull) {
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
    private function isBooleanNot(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ $class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\PropertyProperty $onlyPropertyProperty) : bool
    {
        $isBooleanNot = \false;
        $this->traverseNodesWithCallable((array) $class->stmts, function (\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) use($onlyPropertyProperty, &$isBooleanNot) {
            if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BooleanNot) {
                return null;
            }
            if (!$node->expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch) {
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
    private function matchPropertyFetchNameComparedToNull(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?string
    {
        if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Identical && !$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\NotIdentical) {
            return null;
        }
        if ($node->left instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch && $this->isNull($node->right)) {
            $propertyFetch = $node->left;
        } elseif ($node->right instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch && $this->isNull($node->left)) {
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
