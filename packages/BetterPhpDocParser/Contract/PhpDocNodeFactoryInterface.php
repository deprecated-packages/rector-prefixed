<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Contract;

use PhpParser\Node;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use PHPStan\PhpDocParser\Parser\TokenIterator;
interface PhpDocNodeFactoryInterface
{
    /**
     * @param \PhpParser\Node $node
     * @param \PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator
     * @param string $annotationClass
     */
    public function createFromNodeAndTokens($node, $tokenIterator, $annotationClass) : ?\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
}
