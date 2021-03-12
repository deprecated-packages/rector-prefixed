<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\PhpDocNodeFactory\StringMatchingPhpDocNodeFactory;

use PHPStan\PhpDocParser\Ast\Node;
use PHPStan\PhpDocParser\Parser\TokenIterator;
use Rector\BetterPhpDocParser\Contract\StringTagMatchingPhpDocNodeFactoryInterface;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Nette\NettePersistentTagNode;
final class NettePersistentPhpDocNodeFactory implements \Rector\BetterPhpDocParser\Contract\StringTagMatchingPhpDocNodeFactoryInterface
{
    public function match(string $tag) : bool
    {
        return $tag === \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Nette\NettePersistentTagNode::NAME;
    }
    public function createFromTokens(\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : ?\PHPStan\PhpDocParser\Ast\Node
    {
        return new \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Nette\NettePersistentTagNode();
    }
}
