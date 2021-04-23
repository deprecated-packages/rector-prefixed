<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\PhpDocNodeVisitor;

use PHPStan\PhpDocParser\Ast\Node;
use Rector\BetterPhpDocParser\ValueObject\PhpDocAttributeKey;
use RectorPrefix20210423\Symplify\SimplePhpDocParser\PhpDocNodeVisitor\AbstractPhpDocNodeVisitor;
final class ChangedPhpDocNodeVisitor extends \RectorPrefix20210423\Symplify\SimplePhpDocParser\PhpDocNodeVisitor\AbstractPhpDocNodeVisitor
{
    /**
     * @var bool
     */
    private $hasChanged = \false;
    /**
     * @param \PHPStan\PhpDocParser\Ast\Node $node
     * @return void
     */
    public function beforeTraverse($node)
    {
        $this->hasChanged = \false;
    }
    /**
     * @param \PHPStan\PhpDocParser\Ast\Node $node
     * @return \PHPStan\PhpDocParser\Ast\Node|null
     */
    public function enterNode($node)
    {
        $origNode = $node->getAttribute(\Rector\BetterPhpDocParser\ValueObject\PhpDocAttributeKey::ORIG_NODE);
        if ($origNode === null) {
            $this->hasChanged = \true;
        }
        return null;
    }
    public function hasChanged() : bool
    {
        return $this->hasChanged;
    }
}
