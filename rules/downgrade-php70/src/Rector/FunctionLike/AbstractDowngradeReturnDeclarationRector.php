<?php

declare (strict_types=1);
namespace Rector\DowngradePhp70\Rector\FunctionLike;

use PhpParser\Node;
use PhpParser\Node\FunctionLike;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use PHPStan\Type\IntersectionType;
use PHPStan\Type\IterableType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\UnionType;
use Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTypeChanger;
use Rector\Core\Rector\AbstractRector;
use Rector\DowngradePhp70\Contract\Rector\DowngradeReturnDeclarationRectorInterface;
use Traversable;
abstract class AbstractDowngradeReturnDeclarationRector extends \Rector\Core\Rector\AbstractRector implements \Rector\DowngradePhp70\Contract\Rector\DowngradeReturnDeclarationRectorInterface
{
    /**
     * @var PhpDocTypeChanger
     */
    private $phpDocTypeChanger;
    /**
     * @required
     */
    public function autowireAbstractDowngradeReturnDeclarationRector(\Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTypeChanger $phpDocTypeChanger) : void
    {
        $this->phpDocTypeChanger = $phpDocTypeChanger;
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\Function_::class, \PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod|Function_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
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
    private function decorateFunctionLikeWithReturnTagValueNode(\PhpParser\Node\FunctionLike $functionLike) : void
    {
        if ($functionLike->returnType === null) {
            return;
        }
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($functionLike);
        $type = $this->staticTypeMapper->mapPhpParserNodePHPStanType($functionLike->returnType);
        if ($type instanceof \PHPStan\Type\IterableType) {
            $type = new \PHPStan\Type\UnionType([$type, new \PHPStan\Type\IntersectionType([new \PHPStan\Type\ObjectType(\Traversable::class)])]);
        }
        $this->phpDocTypeChanger->changeReturnType($phpDocInfo, $type);
    }
}
