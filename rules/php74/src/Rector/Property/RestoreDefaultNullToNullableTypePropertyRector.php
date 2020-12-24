<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php74\Rector\Property;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\NullableType;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\PhpParser\NodeTraverser;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Php74\Tests\Rector\Property\RestoreDefaultNullToNullableTypePropertyRector\RestoreDefaultNullToNullableTypePropertyRectorTest
 */
final class RestoreDefaultNullToNullableTypePropertyRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Add null default to properties with PHP 7.4 property nullable type', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public ?string $name;
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public ?string $name = null;
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property::class];
    }
    /**
     * @param Property $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        $onlyProperty = $node->props[0];
        $onlyProperty->default = $this->createNull();
        return $node;
    }
    private function shouldSkip(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property) : bool
    {
        if (!$this->isAtLeastPhpVersion(\_PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature::TYPED_PROPERTIES)) {
            return \true;
        }
        if (!$property->type instanceof \_PhpScopere8e811afab72\PhpParser\Node\NullableType) {
            return \true;
        }
        if (\count((array) $property->props) > 1) {
            return \true;
        }
        $onlyProperty = $property->props[0];
        if ($onlyProperty->default !== null) {
            return \true;
        }
        // is variable assigned in constructor
        $propertyName = $this->getName($property);
        return $this->isPropertyInitiatedInConstuctor($property, $propertyName);
    }
    private function isPropertyInitiatedInConstuctor(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property, string $propertyName) : bool
    {
        $classLike = $property->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_) {
            return \false;
        }
        $constructClassMethod = $classLike->getMethod(\_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if (!$constructClassMethod instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod) {
            return \false;
        }
        $isPropertyInitiated = \false;
        $this->traverseNodesWithCallable((array) $constructClassMethod->stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($propertyName, &$isPropertyInitiated) : ?int {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
                return null;
            }
            if (!$this->isLocalPropertyFetchNamed($node->var, $propertyName)) {
                return null;
            }
            $isPropertyInitiated = \true;
            return \_PhpScopere8e811afab72\PhpParser\NodeTraverser::STOP_TRAVERSAL;
        });
        return $isPropertyInitiated;
    }
}
