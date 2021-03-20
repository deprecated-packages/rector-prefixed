<?php

declare (strict_types=1);
namespace Rector\PHPUnit\PhpDoc\NodeFactory;

use PHPStan\PhpDocParser\Ast\Node;
use PHPStan\PhpDocParser\Parser\TokenIterator;
use Rector\BetterPhpDocParser\Contract\StringTagMatchingPhpDocNodeFactoryInterface;
use Rector\PHPUnit\PhpDoc\Node\PHPUnitDoesNotPerformAssertionTagNode;
final class PHPUnitDataDoesNotPerformAssertionDocNodeFactory implements \Rector\BetterPhpDocParser\Contract\StringTagMatchingPhpDocNodeFactoryInterface
{
    public function createFromTokens(\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : ?\PHPStan\PhpDocParser\Ast\Node
    {
        return new \Rector\PHPUnit\PhpDoc\Node\PHPUnitDoesNotPerformAssertionTagNode();
    }
    public function match(string $tag) : bool
    {
        return \strtolower($tag) === \strtolower(\Rector\PHPUnit\PhpDoc\Node\PHPUnitDoesNotPerformAssertionTagNode::NAME);
    }
}
