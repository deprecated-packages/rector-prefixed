<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php80\Rector\FunctionLike;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrowFunction;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Closure;
use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_;
use _PhpScopere8e811afab72\PhpParser\Node\UnionType as PhpParserUnionType;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Php80\Tests\Rector\FunctionLike\UnionTypesRector\UnionTypesRectorTest
 */
final class UnionTypesRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change docs types to union types, where possible (properties are covered by TypedPropertiesRector)', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @param array|int $number
     * @return bool|float
     */
    public function go($number)
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @param array|int $number
     * @return bool|float
     */
    public function go(array|int $number): bool|float
    {
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\Closure::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrowFunction::class];
    }
    /**
     * @param ClassMethod|Function_|Closure|ArrowFunction $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $phpDocInfo = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return null;
        }
        $this->refactorParamTypes($node, $phpDocInfo);
        $this->refactorReturnType($node, $phpDocInfo);
        return $node;
    }
    /**
     * @param ClassMethod|Function_|Closure|ArrowFunction $functionLike
     */
    private function refactorParamTypes(\_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $functionLike, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : void
    {
        foreach ($functionLike->params as $param) {
            if ($param->type !== null) {
                continue;
            }
            /** @var string $paramName */
            $paramName = $this->getName($param->var);
            $paramType = $phpDocInfo->getParamType($paramName);
            if (!$paramType instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
                continue;
            }
            $phpParserUnionType = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($paramType);
            if (!$phpParserUnionType instanceof \_PhpScopere8e811afab72\PhpParser\Node\UnionType) {
                continue;
            }
            $param->type = $phpParserUnionType;
        }
    }
    /**
     * @param ClassMethod|Function_|Closure|ArrowFunction $functionLike
     */
    private function refactorReturnType(\_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $functionLike, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : void
    {
        // do not override existing return type
        if ($functionLike->getReturnType() !== null) {
            return;
        }
        $returnType = $phpDocInfo->getReturnType();
        if (!$returnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            return;
        }
        $phpParserUnionType = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($returnType);
        if (!$phpParserUnionType instanceof \_PhpScopere8e811afab72\PhpParser\Node\UnionType) {
            return;
        }
        $functionLike->returnType = $phpParserUnionType;
    }
}
