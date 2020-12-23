<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\DowngradePhp70\Rector\FunctionLike;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\FunctionLike;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Function_;
use _PhpScoper0a2ac50786fa\PHPStan\Type\IntersectionType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\IterableType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\UnionType;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\DowngradePhp70\Contract\Rector\DowngradeReturnDeclarationRectorInterface;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use Traversable;
abstract class AbstractDowngradeReturnDeclarationRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector implements \_PhpScoper0a2ac50786fa\Rector\DowngradePhp70\Contract\Rector\DowngradeReturnDeclarationRectorInterface
{
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Function_::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod|Function_ $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
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
    private function decorateFunctionLikeWithReturnTagValueNode(\_PhpScoper0a2ac50786fa\PhpParser\Node\FunctionLike $functionLike) : void
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $functionLike->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            $phpDocInfo = $this->phpDocInfoFactory->createEmpty($functionLike);
        }
        if ($functionLike->returnType === null) {
            return;
        }
        $type = $this->staticTypeMapper->mapPhpParserNodePHPStanType($functionLike->returnType);
        if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\IterableType) {
            $type = new \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType([$type, new \_PhpScoper0a2ac50786fa\PHPStan\Type\IntersectionType([new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType(\Traversable::class)])]);
        }
        $phpDocInfo->changeReturnType($type);
    }
}
