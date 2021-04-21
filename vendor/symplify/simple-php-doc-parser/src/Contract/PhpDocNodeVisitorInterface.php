<?php

declare(strict_types=1);

namespace Symplify\SimplePhpDocParser\Contract;

use PHPStan\PhpDocParser\Ast\Node;

/**
 * Inspired by https://github.com/nikic/PHP-Parser/blob/master/lib/PhpParser/NodeVisitor.php
 */
interface PhpDocNodeVisitorInterface
{
    /**
     * @return void
     */
    public function beforeTraverse(Node $node);

    /**
     * @return \PHPStan\PhpDocParser\Ast\Node|null
     */
    public function enterNode(Node $node);

    /**
     * @return void
     */
    public function leaveNode(Node $node);

    /**
     * @return void
     */
    public function afterTraverse(Node $node);
}
