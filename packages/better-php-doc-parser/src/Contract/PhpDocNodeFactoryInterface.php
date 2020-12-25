<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Contract;

use PhpParser\Node;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use PHPStan\PhpDocParser\Parser\TokenIterator;
interface PhpDocNodeFactoryInterface
{
    public function createFromNodeAndTokens(\PhpParser\Node $node, \PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator, string $annotationClass) : ?\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
}
