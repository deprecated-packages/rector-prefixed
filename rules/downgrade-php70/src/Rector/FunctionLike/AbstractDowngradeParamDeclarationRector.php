<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\DowngradePhp70\Rector\FunctionLike;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\FunctionLike;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Function_;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntersectionType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\IterableType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\DowngradePhp70\Contract\Rector\DowngradeParamDeclarationRectorInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use Traversable;
abstract class AbstractDowngradeParamDeclarationRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector implements \_PhpScoper2a4e7ab1ecbc\Rector\DowngradePhp70\Contract\Rector\DowngradeParamDeclarationRectorInterface
{
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Function_::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod|Function_ $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        if ($node->params === null) {
            return null;
        }
        if ($node->params === []) {
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
    private function refactorParam(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param $param, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\FunctionLike $functionLike) : void
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
    private function decorateWithDocBlock(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\FunctionLike $functionLike, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param $param) : void
    {
        $node = $functionLike;
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            $phpDocInfo = $this->phpDocInfoFactory->createEmpty($node);
        }
        if ($param->type !== null) {
            $type = $this->staticTypeMapper->mapPhpParserNodePHPStanType($param->type);
            if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IterableType) {
                $type = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType([$type, new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntersectionType([new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType(\Traversable::class)])]);
            }
            $paramName = $this->getName($param->var) ?? '';
            $phpDocInfo->changeParamType($type, $param, $paramName);
        }
    }
}
