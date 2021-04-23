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
     * @return void
     */
    public function beforeTraverse(\PHPStan\PhpDocParser\Ast\Node $node);
    public function enterNode(\PHPStan\PhpDocParser\Ast\Node $node) : ?\PHPStan\PhpDocParser\Ast\Node;
    /**
     * @return void
     */
    public function leaveNode(\PHPStan\PhpDocParser\Ast\Node $node);
    /**
     * @return void
     */
    public function afterTraverse(\PHPStan\PhpDocParser\Ast\Node $node);
}
