<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DowngradePhp70\Rector\FunctionLike;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike;
use _PhpScoper0a6b37af0871\PhpParser\Node\Param;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Function_;
use _PhpScoper0a6b37af0871\PHPStan\Type\IntersectionType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IterableType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\UnionType;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\DowngradePhp70\Contract\Rector\DowngradeParamDeclarationRectorInterface;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use Traversable;
abstract class AbstractDowngradeParamDeclarationRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector implements \_PhpScoper0a6b37af0871\Rector\DowngradePhp70\Contract\Rector\DowngradeParamDeclarationRectorInterface
{
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Function_::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod|Function_ $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
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
    private function refactorParam(\_PhpScoper0a6b37af0871\PhpParser\Node\Param $param, \_PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike $functionLike) : void
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
    private function decorateWithDocBlock(\_PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike $functionLike, \_PhpScoper0a6b37af0871\PhpParser\Node\Param $param) : void
    {
        $node = $functionLike;
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            $phpDocInfo = $this->phpDocInfoFactory->createEmpty($node);
        }
        if ($param->type !== null) {
            $type = $this->staticTypeMapper->mapPhpParserNodePHPStanType($param->type);
            if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IterableType) {
                $type = new \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType([$type, new \_PhpScoper0a6b37af0871\PHPStan\Type\IntersectionType([new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType(\Traversable::class)])]);
            }
            $paramName = $this->getName($param->var) ?? '';
            $phpDocInfo->changeParamType($type, $param, $paramName);
        }
    }
}
