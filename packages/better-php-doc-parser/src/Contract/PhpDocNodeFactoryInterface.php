<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Contract;

use PhpParser\Node;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use RectorPrefix20201227\PHPStan\PhpDocParser\Parser\TokenIterator;
interface PhpDocNodeFactoryInterface
{
    public function createFromNodeAndTokens(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator, string $annotationClass) : ?\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
}
