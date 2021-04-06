<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\PhpDocNodeVisitor;

use PHPStan\PhpDocParser\Ast\Node;
use Rector\BetterPhpDocParser\ValueObject\PhpDocAttributeKey;
use RectorPrefix20210406\Symplify\SimplePhpDocParser\PhpDocNodeVisitor\AbstractPhpDocNodeVisitor;
/**
 * Mirror too https://github.com/nikic/PHP-Parser/blob/d520bc9e1d6203c35a1ba20675b79a051c821a9e/lib/PhpParser/NodeVisitor/CloningVisitor.php
 */
final class CloningPhpDocNodeVisitor extends \RectorPrefix20210406\Symplify\SimplePhpDocParser\PhpDocNodeVisitor\AbstractPhpDocNodeVisitor
{
    public function enterNode(\PHPStan\PhpDocParser\Ast\Node $origNode) : ?\PHPStan\PhpDocParser\Ast\Node
    {
        $node = clone $origNode;
        $node->setAttribute(\Rector\BetterPhpDocParser\ValueObject\PhpDocAttributeKey::ORIG_NODE, $origNode);
        return $node;
    }
}
