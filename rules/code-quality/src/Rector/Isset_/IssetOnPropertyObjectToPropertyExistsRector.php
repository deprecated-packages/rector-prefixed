<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodeQuality\Rector\Isset_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Isset_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\ThisType;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\Isset_\IssetOnPropertyObjectToPropertyExistsRector\IssetOnPropertyObjectToPropertyExistsRectorTest
 * @see https://3v4l.org/TI8XL Change isset on property object to property_exists() with not null check
 */
final class IssetOnPropertyObjectToPropertyExistsRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change isset on property object to property_exists()', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    private $x;

    public function run(): void
    {
        isset($this->x);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    private $x;

    public function run(): void
    {
        property_exists($this, 'x') && $this->x !== null;
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\Isset_::class];
    }
    /**
     * @param Isset_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $newNodes = [];
        foreach ($node->vars as $issetVar) {
            if (!$issetVar instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch) {
                continue;
            }
            /** @var Expr $object */
            $object = $issetVar->var->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE);
            /** @var Scope $scope */
            $scope = $object->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
            /** @var ThisType|ObjectType $type */
            $type = $scope->getType($object);
            if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\ThisType) {
                $newNodes[] = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical($issetVar, $this->createNull());
                continue;
            }
            /** @var Identifier|Variable $name */
            $name = $issetVar->name;
            if (!$name instanceof \_PhpScopere8e811afab72\PhpParser\Node\Identifier) {
                continue;
            }
            $property = $name->toString();
            if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\ObjectType) {
                /** @var string $className */
                $className = $type->getClassName();
                $isPropertyAlwaysExists = \property_exists($className, $property);
                if ($isPropertyAlwaysExists) {
                    $newNodes[] = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical($issetVar, $this->createNull());
                    continue;
                }
            }
            $newNodes[] = $this->replaceToPropertyExistsWithNullCheck($object, $property, $issetVar);
        }
        return $this->createReturnNodes($newNodes);
    }
    private function replaceToPropertyExistsWithNullCheck(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr, string $property, \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch $propertyFetch) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BooleanAnd
    {
        $args = [new \_PhpScopere8e811afab72\PhpParser\Node\Arg($expr), new \_PhpScopere8e811afab72\PhpParser\Node\Arg(new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_($property))];
        $propertyExistsFuncCall = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall(new \_PhpScopere8e811afab72\PhpParser\Node\Name('property_exists'), $args);
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BooleanAnd($propertyExistsFuncCall, new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical($propertyFetch, $this->createNull()));
    }
    /**
     * @param NotIdentical[]|BooleanAnd[] $newNodes
     */
    private function createReturnNodes(array $newNodes) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        if ($newNodes === []) {
            return null;
        }
        if (\count($newNodes) === 1) {
            return $newNodes[0];
        }
        return $this->createBooleanAndFromNodes($newNodes);
    }
    /**
     * @param NotIdentical[]|BooleanAnd[] $exprs
     * @todo decouple to StackNodeFactory
     */
    private function createBooleanAndFromNodes(array $exprs) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BooleanAnd
    {
        /** @var NotIdentical|BooleanAnd $booleanAnd */
        $booleanAnd = \array_shift($exprs);
        foreach ($exprs as $expr) {
            $booleanAnd = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BooleanAnd($booleanAnd, $expr);
        }
        /** @var BooleanAnd $booleanAnd */
        return $booleanAnd;
    }
}
