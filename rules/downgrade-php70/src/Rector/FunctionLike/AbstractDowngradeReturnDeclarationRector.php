<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DowngradePhp70\Rector\FunctionLike;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Function_;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IterableType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\DowngradePhp70\Contract\Rector\DowngradeReturnDeclarationRectorInterface;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use Traversable;
abstract class AbstractDowngradeReturnDeclarationRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector implements \_PhpScoperb75b35f52b74\Rector\DowngradePhp70\Contract\Rector\DowngradeReturnDeclarationRectorInterface
{
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Function_::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod|Function_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
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
    private function decorateFunctionLikeWithReturnTagValueNode(\_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike $functionLike) : void
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $functionLike->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            $phpDocInfo = $this->phpDocInfoFactory->createEmpty($functionLike);
        }
        if ($functionLike->returnType === null) {
            return;
        }
        $type = $this->staticTypeMapper->mapPhpParserNodePHPStanType($functionLike->returnType);
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\IterableType) {
            $type = new \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType([$type, new \_PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType([new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType(\Traversable::class)])]);
        }
        $phpDocInfo->changeReturnType($type);
    }
}
