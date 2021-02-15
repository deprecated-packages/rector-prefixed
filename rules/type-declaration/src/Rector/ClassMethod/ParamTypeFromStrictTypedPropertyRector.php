<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\NullableType;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\UnionType;
use PhpParser\NodeTraverser;
use PHPStan\Type\Type;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\PhpVersionFeature;
use RectorPrefix20210215\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\TypeDeclaration\Tests\Rector\ClassMethod\ParamTypeFromStrictTypedPropertyRector\ParamTypeFromStrictTypedPropertyRectorTest
 */
final class ParamTypeFromStrictTypedPropertyRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var SimpleCallableNodeTraverser
     */
    private $simpleCallableNodeTraverser;
    public function __construct(\RectorPrefix20210215\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser $simpleCallableNodeTraverser)
    {
        $this->simpleCallableNodeTraverser = $simpleCallableNodeTraverser;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Add param type from $param set to typed property', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    private int $age;

    public function setAge($age)
    {
        $this->age = $age;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    private int $age;

    public function setAge(int $age)
    {
        $this->age = $age;
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
        return [\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->isAtLeastPhpVersion(\Rector\Core\ValueObject\PhpVersionFeature::TYPED_PROPERTIES)) {
            return null;
        }
        foreach ($node->getParams() as $param) {
            $this->decorateParamWithType($node, $param);
        }
        return $node;
    }
    public function decorateParamWithType(\PhpParser\Node\Stmt\ClassMethod $classMethod, \PhpParser\Node\Param $param) : void
    {
        if ($param->type !== null) {
            return;
        }
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable((array) $classMethod->stmts, function (\PhpParser\Node $node) use($param) : ?int {
            if (!$node instanceof \PhpParser\Node\Expr\Assign) {
                return null;
            }
            if (!$this->areNodesEqual($node->expr, $param)) {
                return null;
            }
            if (!$node->var instanceof \PhpParser\Node\Expr\PropertyFetch) {
                return null;
            }
            $property = $this->matchPropertyWithSingleType($node->var);
            if (!$property instanceof \PhpParser\Node\Stmt\Property) {
                return null;
            }
            $param->type = $property->type;
            return \PhpParser\NodeTraverser::STOP_TRAVERSAL;
        });
    }
    private function matchPropertyWithSingleType(\PhpParser\Node\Expr\PropertyFetch $propertyFetch) : ?\PhpParser\Node\Stmt\Property
    {
        $property = $this->nodeRepository->findPropertyByPropertyFetch($propertyFetch);
        if (!$property instanceof \PhpParser\Node\Stmt\Property) {
            return null;
        }
        if ($property->type === null) {
            return null;
        }
        // move type to param if not union type
        if ($property->type instanceof \PhpParser\Node\UnionType) {
            return null;
        }
        if ($property->type instanceof \PhpParser\Node\NullableType) {
            return null;
        }
        return $property;
    }
}
