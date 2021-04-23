<?php

declare (strict_types=1);
namespace RectorPrefix20210423\Symplify\SimplePhpDocParser\PhpDocNodeVisitor;

use PHPStan\PhpDocParser\Ast\Node;
use RectorPrefix20210423\Symplify\SimplePhpDocParser\Contract\PhpDocNodeVisitorInterface;
/**
 * Inspired by https://github.com/nikic/PHP-Parser/blob/master/lib/PhpParser/NodeVisitorAbstract.php
 */
abstract class AbstractPhpDocNodeVisitor implements \RectorPrefix20210423\Symplify\SimplePhpDocParser\Contract\PhpDocNodeVisitorInterface
{
    /**
     * @param \PHPStan\PhpDocParser\Ast\Node $node
     * @return void
     */
    public function beforeTraverse($node)
    {
    }
    /**
     * @param \PHPStan\PhpDocParser\Ast\Node $node
     * @return \PHPStan\PhpDocParser\Ast\Node|null
     */
    public function enterNode($node)
    {
        return null;
    }
    /**
     * @param \PHPStan\PhpDocParser\Ast\Node $node
     * @return void
     */
    public function leaveNode($node)
    {
    }
    /**
     * @param \PHPStan\PhpDocParser\Ast\Node $node
     * @return void
     */
    public function afterTraverse($node)
    {
    }
}
