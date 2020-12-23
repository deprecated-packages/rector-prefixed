<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\CodeQuality\Rector\Isset_;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Arg;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Isset_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Identifier;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ThisType;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\Isset_\IssetOnPropertyObjectToPropertyExistsRector\IssetOnPropertyObjectToPropertyExistsRectorTest
 * @see https://3v4l.org/TI8XL Change isset on property object to property_exists() with not null check
 */
final class IssetOnPropertyObjectToPropertyExistsRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change isset on property object to property_exists()', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Isset_::class];
    }
    /**
     * @param Isset_ $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $newNodes = [];
        foreach ($node->vars as $issetVar) {
            if (!$issetVar instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch) {
                continue;
            }
            /** @var Expr $object */
            $object = $issetVar->var->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE);
            /** @var Scope $scope */
            $scope = $object->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
            /** @var ThisType|ObjectType $type */
            $type = $scope->getType($object);
            if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ThisType) {
                $newNodes[] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical($issetVar, $this->createNull());
                continue;
            }
            /** @var Identifier|Variable $name */
            $name = $issetVar->name;
            if (!$name instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier) {
                continue;
            }
            $property = $name->toString();
            if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType) {
                /** @var string $className */
                $className = $type->getClassName();
                $isPropertyAlwaysExists = \property_exists($className, $property);
                if ($isPropertyAlwaysExists) {
                    $newNodes[] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical($issetVar, $this->createNull());
                    continue;
                }
            }
            $newNodes[] = $this->replaceToPropertyExistsWithNullCheck($object, $property, $issetVar);
        }
        return $this->createReturnNodes($newNodes);
    }
    private function replaceToPropertyExistsWithNullCheck(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $expr, string $property, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch $propertyFetch) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\BooleanAnd
    {
        $args = [new \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg($expr), new \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_($property))];
        $propertyExistsFuncCall = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name('property_exists'), $args);
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\BooleanAnd($propertyExistsFuncCall, new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical($propertyFetch, $this->createNull()));
    }
    /**
     * @param NotIdentical[]|BooleanAnd[] $newNodes
     */
    private function createReturnNodes(array $newNodes) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr
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
    private function createBooleanAndFromNodes(array $exprs) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\BooleanAnd
    {
        /** @var NotIdentical|BooleanAnd $booleanAnd */
        $booleanAnd = \array_shift($exprs);
        foreach ($exprs as $expr) {
            $booleanAnd = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\BooleanAnd($booleanAnd, $expr);
        }
        /** @var BooleanAnd $booleanAnd */
        return $booleanAnd;
    }
}
