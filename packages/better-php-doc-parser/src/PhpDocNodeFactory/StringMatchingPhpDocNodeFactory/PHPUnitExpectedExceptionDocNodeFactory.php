<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\PhpDocNodeFactory\StringMatchingPhpDocNodeFactory;

use PHPStan\PhpDocParser\Ast\Node;
use PHPStan\PhpDocParser\Parser\TokenIterator;
use PHPStan\PhpDocParser\Parser\TypeParser;
use Rector\BetterPhpDocParser\Contract\StringTagMatchingPhpDocNodeFactoryInterface;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\PHPUnit\PHPUnitExpectedExceptionTagValueNode;
final class PHPUnitExpectedExceptionDocNodeFactory implements \Rector\BetterPhpDocParser\Contract\StringTagMatchingPhpDocNodeFactoryInterface
{
    /**
     * @var TypeParser
     */
    private $typeParser;
    public function __construct(\PHPStan\PhpDocParser\Parser\TypeParser $typeParser)
    {
        $this->typeParser = $typeParser;
    }
    public function createFromTokens(\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : ?\PHPStan\PhpDocParser\Ast\Node
    {
        $type = $this->typeParser->parse($tokenIterator);
        return new \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\PHPUnit\PHPUnitExpectedExceptionTagValueNode($type);
    }
    public function match(string $tag) : bool
    {
        return \strtolower($tag) === \strtolower(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\PHPUnit\PHPUnitExpectedExceptionTagValueNode::NAME);
    }
}
