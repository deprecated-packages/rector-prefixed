<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\NullableType;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use PhpParser\Node\Stmt\Return_;
use PhpParser\Node\UnionType;
use PhpParser\Node\UnionType as PhpParserUnionType;
use PHPStan\Type\Type;
use Rector\CodingStyle\ValueObject\ObjectMagicMethods;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\PhpVersionFeature;
use Rector\TypeDeclaration\NodeAnalyzer\TypeNodeUnwrapper;
use Rector\TypeDeclaration\Reflection\ReflectionTypeResolver;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\TypeDeclaration\Tests\Rector\ClassMethod\ReturnTypeFromStrictTypedCallRector\ReturnTypeFromStrictTypedCallRectorTest
 */
final class ReturnTypeFromStrictTypedCallRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var ReflectionTypeResolver
     */
    private $reflectionTypeResolver;
    /**
     * @var TypeNodeUnwrapper
     */
    private $typeNodeUnwrapper;
    public function __construct(\Rector\TypeDeclaration\Reflection\ReflectionTypeResolver $reflectionTypeResolver, \Rector\TypeDeclaration\NodeAnalyzer\TypeNodeUnwrapper $typeNodeUnwrapper)
    {
        $this->reflectionTypeResolver = $reflectionTypeResolver;
        $this->typeNodeUnwrapper = $typeNodeUnwrapper;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Add return type from strict return type of call', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    public function getData()
    {
        return $this->getNumber();
    }

    private function getNumber(): int
    {
        return 1000;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    public function getData(): int
    {
        return $this->getNumber();
    }

    private function getNumber(): int
    {
        return 1000;
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
        return [\PhpParser\Node\Stmt\ClassMethod::class, \PhpParser\Node\Stmt\Function_::class, \PhpParser\Node\Expr\Closure::class];
    }
    /**
     * @param ClassMethod|Function_|Closure $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->phpVersionProvider->isAtLeastPhpVersion(\Rector\Core\ValueObject\PhpVersionFeature::SCALAR_TYPES)) {
            return null;
        }
        if ($node->returnType !== null) {
            return null;
        }
        if ($this->isNames($node, \Rector\CodingStyle\ValueObject\ObjectMagicMethods::METHOD_NAMES)) {
            return null;
        }
        /** @var Return_[] $returns */
        $returns = $this->betterNodeFinder->findInstanceOf((array) $node->stmts, \PhpParser\Node\Stmt\Return_::class);
        $returnedStrictTypes = $this->collectStrictReturnTypes($returns);
        if ($returnedStrictTypes === []) {
            return null;
        }
        if (\count($returnedStrictTypes) === 1) {
            $node->returnType = $returnedStrictTypes[0];
            return $node;
        }
        if ($this->isAtLeastPhpVersion(\Rector\Core\ValueObject\PhpVersionFeature::UNION_TYPES)) {
            $unwrappedTypes = $this->typeNodeUnwrapper->unwrapNullableUnionTypes($returnedStrictTypes);
            $node->returnType = new \PhpParser\Node\UnionType($unwrappedTypes);
            return $node;
        }
        return null;
    }
    /**
     * @param Return_[] $returns
     * @return array<Name|NullableType|UnionType>
     */
    private function collectStrictReturnTypes(array $returns) : array
    {
        $returnedStrictTypeNodes = [];
        foreach ($returns as $return) {
            if ($return->expr === null) {
                return [];
            }
            $returnedExpr = $return->expr;
            if ($returnedExpr instanceof \PhpParser\Node\Expr\MethodCall) {
                $returnNode = $this->resolveMethodCallReturnNode($returnedExpr);
            } elseif ($returnedExpr instanceof \PhpParser\Node\Expr\StaticCall) {
                $returnNode = $this->resolveStaticCallReturnNode($returnedExpr);
            } elseif ($returnedExpr instanceof \PhpParser\Node\Expr\FuncCall) {
                $returnNode = $this->resolveFuncCallReturnNode($returnedExpr);
            } else {
                return [];
            }
            if (!$returnNode instanceof \PhpParser\Node) {
                return [];
            }
            $returnedStrictTypeNodes[] = $returnNode;
        }
        return $this->typeNodeUnwrapper->uniquateNodes($returnedStrictTypeNodes);
    }
    private function resolveMethodCallReturnNode(\PhpParser\Node\Expr\MethodCall $methodCall) : ?\PhpParser\Node
    {
        $classMethod = $this->nodeRepository->findClassMethodByMethodCall($methodCall);
        if ($classMethod instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return $classMethod->returnType;
        }
        $returnType = $this->reflectionTypeResolver->resolveMethodCallReturnType($methodCall);
        if (!$returnType instanceof \PHPStan\Type\Type) {
            return null;
        }
        return $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($returnType);
    }
    private function resolveStaticCallReturnNode(\PhpParser\Node\Expr\StaticCall $staticCall) : ?\PhpParser\Node
    {
        $classMethod = $this->nodeRepository->findClassMethodByStaticCall($staticCall);
        if ($classMethod instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return $classMethod->returnType;
        }
        $returnType = $this->reflectionTypeResolver->resolveStaticCallReturnType($staticCall);
        if (!$returnType instanceof \PHPStan\Type\Type) {
            return null;
        }
        return $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($returnType);
    }
    /**
     * @return Identifier|Name|NullableType|PhpParserUnionType|null
     */
    private function resolveFuncCallReturnNode(\PhpParser\Node\Expr\FuncCall $funcCall) : ?\PhpParser\Node
    {
        $function = $this->nodeRepository->findFunctionByFuncCall($funcCall);
        if ($function instanceof \PhpParser\Node\Stmt\Function_) {
            return $function->returnType;
        }
        $returnType = $this->reflectionTypeResolver->resolveFuncCallReturnType($funcCall);
        if (!$returnType instanceof \PHPStan\Type\Type) {
            return null;
        }
        return $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($returnType);
    }
}
