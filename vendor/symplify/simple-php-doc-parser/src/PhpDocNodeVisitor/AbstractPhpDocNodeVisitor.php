<?php

declare (strict_types=1);
namespace RectorPrefix20210420\Symplify\SimplePhpDocParser\PhpDocNodeVisitor;

use PHPStan\PhpDocParser\Ast\Node;
use RectorPrefix20210420\Symplify\SimplePhpDocParser\Contract\PhpDocNodeVisitorInterface;
/**
 * Inspired by https://github.com/nikic/PHP-Parser/blob/master/lib/PhpParser/NodeVisitorAbstract.php
 */
abstract class AbstractPhpDocNodeVisitor implements \RectorPrefix20210420\Symplify\SimplePhpDocParser\Contract\PhpDocNodeVisitorInterface
{
    /**
     * @return void
     */
    public function beforeTraverse(\PHPStan\PhpDocParser\Ast\Node $node)
    {
    }
    /**
     * @return \PHPStan\PhpDocParser\Ast\Node|null
     */
    public function enterNode(\PHPStan\PhpDocParser\Ast\Node $node)
    {
        return null;
    }
    /**
     * @return void
     */
    public function leaveNode(\PHPStan\PhpDocParser\Ast\Node $node)
    {
    }
    /**
     * @return void
     */
    public function afterTraverse(\PHPStan\PhpDocParser\Ast\Node $node)
    {
    }
}
