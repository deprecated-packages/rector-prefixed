<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DowngradePhp70\Rector\FunctionLike;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_;
use _PhpScopere8e811afab72\PHPStan\Type\IntersectionType;
use _PhpScopere8e811afab72\PHPStan\Type\IterableType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\DowngradePhp70\Contract\Rector\DowngradeParamDeclarationRectorInterface;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use Traversable;
abstract class AbstractDowngradeParamDeclarationRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\DowngradePhp70\Contract\Rector\DowngradeParamDeclarationRectorInterface
{
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod|Function_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($node->params === null || $node->params === []) {
            return null;
        }
        foreach ($node->params as $param) {
            $this->refactorParam($param, $node);
        }
        return null;
    }
    /**
     * @param ClassMethod|Function_ $functionLike
     */
    private function refactorParam(\_PhpScopere8e811afab72\PhpParser\Node\Param $param, \_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $functionLike) : void
    {
        if (!$this->shouldRemoveParamDeclaration($param, $functionLike)) {
            return;
        }
        $this->decorateWithDocBlock($functionLike, $param);
        $param->type = null;
    }
    /**
     * @param ClassMethod|Function_ $functionLike
     */
    private function decorateWithDocBlock(\_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $functionLike, \_PhpScopere8e811afab72\PhpParser\Node\Param $param) : void
    {
        $node = $functionLike;
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            $phpDocInfo = $this->phpDocInfoFactory->createEmpty($node);
        }
        if ($param->type !== null) {
            $type = $this->staticTypeMapper->mapPhpParserNodePHPStanType($param->type);
            if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\IterableType) {
                $type = new \_PhpScopere8e811afab72\PHPStan\Type\UnionType([$type, new \_PhpScopere8e811afab72\PHPStan\Type\IntersectionType([new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType(\Traversable::class)])]);
            }
            $paramName = $this->getName($param->var) ?? '';
            $phpDocInfo->changeParamType($type, $param, $paramName);
        }
    }
}
