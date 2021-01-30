<?php

declare (strict_types=1);
namespace Rector\CodeQuality\Rector\Isset_;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use PhpParser\Node\Expr\BinaryOp\NotIdentical;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\Isset_;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Scalar\String_;
use PHPStan\Analyser\Scope;
use PHPStan\Type\ObjectType;
use PHPStan\Type\ThisType;
use PHPStan\Type\Type;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\Isset_\IssetOnPropertyObjectToPropertyExistsRector\IssetOnPropertyObjectToPropertyExistsRectorTest
 * @see https://3v4l.org/TI8XL Change isset on property object to property_exists() with not null check
 */
final class IssetOnPropertyObjectToPropertyExistsRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change isset on property object to property_exists()', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\PhpParser\Node\Expr\Isset_::class];
    }
    /**
     * @param Isset_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $newNodes = [];
        foreach ($node->vars as $issetVar) {
            if (!$issetVar instanceof \PhpParser\Node\Expr\PropertyFetch) {
                continue;
            }
            /** @var Expr $object */
            $object = $issetVar->var->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE);
            /** @var ThisType|ObjectType|null $type */
            $type = $this->getType($object);
            /** @var Identifier|Variable $name */
            $name = $issetVar->name;
            if ($type === null || !$name instanceof \PhpParser\Node\Identifier) {
                continue;
            }
            if ($type instanceof \PHPStan\Type\ThisType) {
                $newNodes[] = new \PhpParser\Node\Expr\BinaryOp\NotIdentical($issetVar, $this->nodeFactory->createNull());
                continue;
            }
            $property = $name->toString();
            if ($type instanceof \PHPStan\Type\ObjectType) {
                /** @var string $className */
                $className = $type->getClassName();
                $isPropertyAlwaysExists = \property_exists($className, $property);
                if ($isPropertyAlwaysExists) {
                    $newNodes[] = new \PhpParser\Node\Expr\BinaryOp\NotIdentical($issetVar, $this->nodeFactory->createNull());
                    continue;
                }
            }
            $newNodes[] = $this->replaceToPropertyExistsWithNullCheck($object, $property, $issetVar);
        }
        return $this->createReturnNodes($newNodes);
    }
    private function getType(\PhpParser\Node\Expr $expr) : ?\PHPStan\Type\Type
    {
        $scope = $expr->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \PHPStan\Analyser\Scope) {
            return null;
        }
        return $scope->getType($expr);
    }
    private function replaceToPropertyExistsWithNullCheck(\PhpParser\Node\Expr $expr, string $property, \PhpParser\Node\Expr\PropertyFetch $propertyFetch) : \PhpParser\Node\Expr\BinaryOp\BooleanAnd
    {
        $args = [new \PhpParser\Node\Arg($expr), new \PhpParser\Node\Arg(new \PhpParser\Node\Scalar\String_($property))];
        $propertyExistsFuncCall = new \PhpParser\Node\Expr\FuncCall(new \PhpParser\Node\Name('property_exists'), $args);
        return new \PhpParser\Node\Expr\BinaryOp\BooleanAnd($propertyExistsFuncCall, new \PhpParser\Node\Expr\BinaryOp\NotIdentical($propertyFetch, $this->nodeFactory->createNull()));
    }
    /**
     * @param NotIdentical[]|BooleanAnd[] $newNodes
     */
    private function createReturnNodes(array $newNodes) : ?\PhpParser\Node\Expr
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
    private function createBooleanAndFromNodes(array $exprs) : \PhpParser\Node\Expr\BinaryOp\BooleanAnd
    {
        /** @var NotIdentical|BooleanAnd $booleanAnd */
        $booleanAnd = \array_shift($exprs);
        foreach ($exprs as $expr) {
            $booleanAnd = new \PhpParser\Node\Expr\BinaryOp\BooleanAnd($booleanAnd, $expr);
        }
        /** @var BooleanAnd $booleanAnd */
        return $booleanAnd;
    }
}
