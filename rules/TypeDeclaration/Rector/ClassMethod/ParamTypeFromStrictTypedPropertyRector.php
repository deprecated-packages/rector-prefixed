<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Expr\ArrowFunction;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\FunctionLike;
use PhpParser\Node\NullableType;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\UnionType;
use PhpParser\NodeTraverser;
use PHPStan\Type\Type;
use Rector\ChangesReporting\ValueObject\RectorWithLineChange;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\PhpVersionFeature;
use Rector\TypeDeclaration\Reflection\ReflectionTypeResolver;
use RectorPrefix20210423\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Tests\TypeDeclaration\Rector\ClassMethod\ParamTypeFromStrictTypedPropertyRector\ParamTypeFromStrictTypedPropertyRectorTest
 */
final class ParamTypeFromStrictTypedPropertyRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var SimpleCallableNodeTraverser
     */
    private $simpleCallableNodeTraverser;
    /**
     * @var ReflectionTypeResolver
     */
    private $reflectionTypeResolver;
    public function __construct(\RectorPrefix20210423\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser $simpleCallableNodeTraverser, \Rector\TypeDeclaration\Reflection\ReflectionTypeResolver $reflectionTypeResolver)
    {
        $this->simpleCallableNodeTraverser = $simpleCallableNodeTraverser;
        $this->reflectionTypeResolver = $reflectionTypeResolver;
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
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\ClassMethod::class, \PhpParser\Node\Stmt\Function_::class, \PhpParser\Node\Expr\Closure::class, \PhpParser\Node\Expr\ArrowFunction::class];
    }
    /**
     * @param ClassMethod|Function_|Closure|ArrowFunction $node
     * @return \PhpParser\Node|null
     */
    public function refactor(\PhpParser\Node $node)
    {
        if (!$this->isAtLeastPhpVersion(\Rector\Core\ValueObject\PhpVersionFeature::TYPED_PROPERTIES)) {
            return null;
        }
        foreach ($node->getParams() as $param) {
            $this->decorateParamWithType($node, $param);
        }
        return $node;
    }
    /**
     * @param ClassMethod|Function_|Closure|ArrowFunction $functionLike
     * @return void
     */
    public function decorateParamWithType(\PhpParser\Node\FunctionLike $functionLike, \PhpParser\Node\Param $param)
    {
        if ($param->type !== null) {
            return;
        }
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable((array) $functionLike->getStmts(), function (\PhpParser\Node $node) use($param) : ?int {
            if (!$node instanceof \PhpParser\Node\Expr\Assign) {
                return null;
            }
            if (!$this->nodeComparator->areNodesEqual($node->expr, $param)) {
                return null;
            }
            if (!$node->var instanceof \PhpParser\Node\Expr\PropertyFetch) {
                return null;
            }
            $singlePropertyTypeNode = $this->matchPropertySingleTypeNode($node->var);
            if (!$singlePropertyTypeNode instanceof \PhpParser\Node) {
                return null;
            }
            $rectorWithLineChange = new \Rector\ChangesReporting\ValueObject\RectorWithLineChange($this, $node->getLine());
            $this->file->addRectorClassWithLine($rectorWithLineChange);
            $param->type = $singlePropertyTypeNode;
            return \PhpParser\NodeTraverser::STOP_TRAVERSAL;
        });
    }
    /**
     * @return \PhpParser\Node|null
     */
    private function matchPropertySingleTypeNode(\PhpParser\Node\Expr\PropertyFetch $propertyFetch)
    {
        $property = $this->nodeRepository->findPropertyByPropertyFetch($propertyFetch);
        if (!$property instanceof \PhpParser\Node\Stmt\Property) {
            // code from /vendor
            $propertyFetchType = $this->reflectionTypeResolver->resolvePropertyFetchType($propertyFetch);
            if (!$propertyFetchType instanceof \PHPStan\Type\Type) {
                return null;
            }
            return $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($propertyFetchType);
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
        return $property->type;
    }
}
