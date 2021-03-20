<?php

declare (strict_types=1);
namespace Rector\Nette\PhpDoc\NodeFactory;

use PHPStan\PhpDocParser\Ast\Node;
use PHPStan\PhpDocParser\Parser\TokenIterator;
use Rector\BetterPhpDocParser\Contract\StringTagMatchingPhpDocNodeFactoryInterface;
use Rector\Nette\PhpDoc\Node\NetteCrossOriginTagNode;
final class NetteCrossOriginPhpDocNodeFactory implements \Rector\BetterPhpDocParser\Contract\StringTagMatchingPhpDocNodeFactoryInterface
{
    public function match(string $tag) : bool
    {
        return $tag === \Rector\Nette\PhpDoc\Node\NetteCrossOriginTagNode::NAME;
    }
    public function createFromTokens(\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : ?\PHPStan\PhpDocParser\Ast\Node
    {
        return new \Rector\Nette\PhpDoc\Node\NetteCrossOriginTagNode();
    }
}
