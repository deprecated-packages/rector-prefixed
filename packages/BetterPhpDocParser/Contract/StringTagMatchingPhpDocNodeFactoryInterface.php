<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Contract;

use PHPStan\PhpDocParser\Ast\Node;
use PHPStan\PhpDocParser\Parser\TokenIterator;
interface StringTagMatchingPhpDocNodeFactoryInterface
{
    /**
     * @param string $tag
     */
    public function match($tag) : bool;
    /**
     * @param \PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator
     */
    public function createFromTokens($tokenIterator) : ?\PHPStan\PhpDocParser\Ast\Node;
}
