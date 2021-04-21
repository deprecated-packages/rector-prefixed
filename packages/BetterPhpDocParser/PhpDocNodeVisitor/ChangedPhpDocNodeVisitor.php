<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\PhpDocNodeVisitor;

use PHPStan\PhpDocParser\Ast\Node;
use Rector\BetterPhpDocParser\ValueObject\PhpDocAttributeKey;
use RectorPrefix20210421\Symplify\SimplePhpDocParser\PhpDocNodeVisitor\AbstractPhpDocNodeVisitor;
final class ChangedPhpDocNodeVisitor extends \RectorPrefix20210421\Symplify\SimplePhpDocParser\PhpDocNodeVisitor\AbstractPhpDocNodeVisitor
{
    /**
     * @var bool
     */
    private $hasChanged = \false;
    /**
     * @return void
     */
    public function beforeTraverse(\PHPStan\PhpDocParser\Ast\Node $node)
    {
        $this->hasChanged = \false;
    }
    /**
     * @return \PHPStan\PhpDocParser\Ast\Node|null
     */
    public function enterNode(\PHPStan\PhpDocParser\Ast\Node $node)
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
