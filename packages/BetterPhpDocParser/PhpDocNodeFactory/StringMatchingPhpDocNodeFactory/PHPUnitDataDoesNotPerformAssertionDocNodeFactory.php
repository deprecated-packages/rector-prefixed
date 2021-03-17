<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\PhpDocNodeFactory\StringMatchingPhpDocNodeFactory;

use PHPStan\PhpDocParser\Ast\Node;
use PHPStan\PhpDocParser\Parser\TokenIterator;
use Rector\BetterPhpDocParser\Contract\StringTagMatchingPhpDocNodeFactoryInterface;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\PHPUnit\PHPUnitDoesNotPerformAssertionTagNode;
final class PHPUnitDataDoesNotPerformAssertionDocNodeFactory implements \Rector\BetterPhpDocParser\Contract\StringTagMatchingPhpDocNodeFactoryInterface
{
    /**
     * @param \PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator
     */
    public function createFromTokens($tokenIterator) : ?\PHPStan\PhpDocParser\Ast\Node
    {
        return new \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\PHPUnit\PHPUnitDoesNotPerformAssertionTagNode();
    }
    /**
     * @param string $tag
     */
    public function match($tag) : bool
    {
        return \strtolower($tag) === \strtolower(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\PHPUnit\PHPUnitDoesNotPerformAssertionTagNode::NAME);
    }
}
