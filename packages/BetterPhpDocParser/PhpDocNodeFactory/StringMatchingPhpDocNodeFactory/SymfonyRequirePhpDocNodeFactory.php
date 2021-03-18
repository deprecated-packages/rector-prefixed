<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\PhpDocNodeFactory\StringMatchingPhpDocNodeFactory;

use PHPStan\PhpDocParser\Ast\Node;
use PHPStan\PhpDocParser\Parser\TokenIterator;
use Rector\AttributeAwarePhpDoc\Ast\PhpDoc\SymfonyRequiredTagNode;
use Rector\BetterPhpDocParser\Contract\StringTagMatchingPhpDocNodeFactoryInterface;
final class SymfonyRequirePhpDocNodeFactory implements \Rector\BetterPhpDocParser\Contract\StringTagMatchingPhpDocNodeFactoryInterface
{
    /**
     * @param string $tag
     */
    public function match($tag) : bool
    {
        return $tag === \Rector\AttributeAwarePhpDoc\Ast\PhpDoc\SymfonyRequiredTagNode::NAME;
    }
    /**
     * @param \PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator
     */
    public function createFromTokens($tokenIterator) : ?\PHPStan\PhpDocParser\Ast\Node
    {
        return new \Rector\AttributeAwarePhpDoc\Ast\PhpDoc\SymfonyRequiredTagNode();
    }
}
