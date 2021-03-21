<?php

declare (strict_types=1);
namespace Rector\Symfony\PhpDoc\NodeFactory;

use PHPStan\PhpDocParser\Ast\Node;
use PHPStan\PhpDocParser\Parser\TokenIterator;
use Rector\BetterPhpDocParser\Contract\StringTagMatchingPhpDocNodeFactoryInterface;
use Rector\Symfony\PhpDoc\Node\SymfonyRequiredTagNode;
final class SymfonyRequirePhpDocNodeFactory implements \Rector\BetterPhpDocParser\Contract\StringTagMatchingPhpDocNodeFactoryInterface
{
    public function match(string $tag) : bool
    {
        return $tag === \Rector\Symfony\PhpDoc\Node\SymfonyRequiredTagNode::NAME;
    }
    public function createFromTokens(\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : ?\PHPStan\PhpDocParser\Ast\Node
    {
        return new \Rector\Symfony\PhpDoc\Node\SymfonyRequiredTagNode();
    }
}
