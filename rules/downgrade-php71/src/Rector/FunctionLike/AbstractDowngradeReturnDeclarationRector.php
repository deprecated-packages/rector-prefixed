<?php

declare (strict_types=1);
namespace Rector\DowngradePhp71\Rector\FunctionLike;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\DowngradePhp71\Contract\Rector\DowngradeReturnDeclarationRectorInterface;
use Rector\NodeTypeResolver\Node\AttributeKey;
abstract class AbstractDowngradeReturnDeclarationRector extends \Rector\DowngradePhp71\Rector\FunctionLike\AbstractDowngradeRector implements \Rector\DowngradePhp71\Contract\Rector\DowngradeReturnDeclarationRectorInterface
{
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
        if ($this->addDocBlock) {
            /** @var PhpDocInfo|null $phpDocInfo */
            $phpDocInfo = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
            if ($phpDocInfo === null) {
                $phpDocInfo = $this->phpDocInfoFactory->createEmpty($node);
            }
            if ($node->returnType !== null) {
                $type = $this->staticTypeMapper->mapPhpParserNodePHPStanType($node->returnType);
                $phpDocInfo->changeReturnType($type);
            }
        }
        $node->returnType = null;
        return $node;
    }
}
