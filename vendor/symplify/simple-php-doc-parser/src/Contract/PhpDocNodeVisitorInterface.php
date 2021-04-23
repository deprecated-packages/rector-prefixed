<?php

declare (strict_types=1);
namespace RectorPrefix20210423\Symplify\SimplePhpDocParser\Contract;

use PHPStan\PhpDocParser\Ast\Node;
/**
 * Inspired by https://github.com/nikic/PHP-Parser/blob/master/lib/PhpParser/NodeVisitor.php
 */
interface PhpDocNodeVisitorInterface
{
    /**
     * @param \PHPStan\PhpDocParser\Ast\Node $node
     * @return void
     */
    public function beforeTraverse($node);
    /**
     * @param \PHPStan\PhpDocParser\Ast\Node $node
     * @return \PHPStan\PhpDocParser\Ast\Node|null
     */
    public function enterNode($node);
    /**
     * @param \PHPStan\PhpDocParser\Ast\Node $node
     * @return void
     */
    public function leaveNode($node);
    /**
     * @param \PHPStan\PhpDocParser\Ast\Node $node
     * @return void
     */
    public function afterTraverse($node);
}
