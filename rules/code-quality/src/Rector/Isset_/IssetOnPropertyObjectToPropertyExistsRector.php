<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodeQuality\Rector\Isset_;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Isset_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ThisType;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\Isset_\IssetOnPropertyObjectToPropertyExistsRector\IssetOnPropertyObjectToPropertyExistsRectorTest
 * @see https://3v4l.org/TI8XL Change isset on property object to property_exists() with not null check
 */
final class IssetOnPropertyObjectToPropertyExistsRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change isset on property object to property_exists()', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Isset_::class];
    }
    /**
     * @param Isset_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $newNodes = [];
        foreach ($node->vars as $issetVar) {
            if (!$issetVar instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch) {
                continue;
            }
            /** @var Expr $object */
            $object = $issetVar->var->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE);
            /** @var Scope $scope */
            $scope = $object->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
            /** @var ThisType|ObjectType $type */
            $type = $scope->getType($object);
            if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ThisType) {
                $newNodes[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotIdentical($issetVar, $this->createNull());
                continue;
            }
            /** @var Identifier|Variable $name */
            $name = $issetVar->name;
            if (!$name instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier) {
                continue;
            }
            $property = $name->toString();
            if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType) {
                /** @var string $className */
                $className = $type->getClassName();
                $isPropertyAlwaysExists = \property_exists($className, $property);
                if ($isPropertyAlwaysExists) {
                    $newNodes[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotIdentical($issetVar, $this->createNull());
                    continue;
                }
            }
            $newNodes[] = $this->replaceToPropertyExistsWithNullCheck($object, $property, $issetVar);
        }
        return $this->createReturnNodes($newNodes);
    }
    private function replaceToPropertyExistsWithNullCheck(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr, string $property, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch $propertyFetch) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\BooleanAnd
    {
        $args = [new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg($expr), new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg(new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_($property))];
        $propertyExistsFuncCall = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name('property_exists'), $args);
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\BooleanAnd($propertyExistsFuncCall, new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotIdentical($propertyFetch, $this->createNull()));
    }
    /**
     * @param NotIdentical[]|BooleanAnd[] $newNodes
     */
    private function createReturnNodes(array $newNodes) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr
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
    private function createBooleanAndFromNodes(array $exprs) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\BooleanAnd
    {
        /** @var NotIdentical|BooleanAnd $booleanAnd */
        $booleanAnd = \array_shift($exprs);
        foreach ($exprs as $expr) {
            $booleanAnd = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\BooleanAnd($booleanAnd, $expr);
        }
        /** @var BooleanAnd $booleanAnd */
        return $booleanAnd;
    }
}
