<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DowngradePhp70\Rector\FunctionLike;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_;
use _PhpScopere8e811afab72\PHPStan\Type\IntersectionType;
use _PhpScopere8e811afab72\PHPStan\Type\IterableType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\DowngradePhp70\Contract\Rector\DowngradeReturnDeclarationRectorInterface;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use Traversable;
abstract class AbstractDowngradeReturnDeclarationRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\DowngradePhp70\Contract\Rector\DowngradeReturnDeclarationRectorInterface
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
        if (!$this->shouldRemoveReturnDeclaration($node)) {
            return null;
        }
        $this->decorateFunctionLikeWithReturnTagValueNode($node);
        $node->returnType = null;
        return $node;
    }
    /**
     * @param ClassMethod|Function_ $functionLike
     */
    private function decorateFunctionLikeWithReturnTagValueNode(\_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $functionLike) : void
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $functionLike->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            $phpDocInfo = $this->phpDocInfoFactory->createEmpty($functionLike);
        }
        if ($functionLike->returnType === null) {
            return;
        }
        $type = $this->staticTypeMapper->mapPhpParserNodePHPStanType($functionLike->returnType);
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\IterableType) {
            $type = new \_PhpScopere8e811afab72\PHPStan\Type\UnionType([$type, new \_PhpScopere8e811afab72\PHPStan\Type\IntersectionType([new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType(\Traversable::class)])]);
        }
        $phpDocInfo->changeReturnType($type);
    }
}
