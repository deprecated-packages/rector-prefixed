<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\PhpDocNodeFactory\StringMatchingPhpDocNodeFactory;

use PHPStan\PhpDocParser\Ast\Node;
use PHPStan\PhpDocParser\Parser\TokenIterator;
use Rector\BetterPhpDocParser\Contract\StringTagMatchingPhpDocNodeFactoryInterface;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\PHPUnit\PHPUnitDoesNotPerformAssertionTagNode;
final class PHPUnitDataDoesNotPerformAssertionDocNodeFactory implements \Rector\BetterPhpDocParser\Contract\StringTagMatchingPhpDocNodeFactoryInterface
{
    public function createFromTokens(\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : ?\PHPStan\PhpDocParser\Ast\Node
    {
        return new \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\PHPUnit\PHPUnitDoesNotPerformAssertionTagNode();
    }
    public function match(string $tag) : bool
    {
        return \strtolower($tag) === \strtolower(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\PHPUnit\PHPUnitDoesNotPerformAssertionTagNode::NAME);
    }
}
