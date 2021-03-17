<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\PhpDocNodeFactory\StringMatchingPhpDocNodeFactory;

use PHPStan\PhpDocParser\Ast\Node;
use PHPStan\PhpDocParser\Ast\PhpDoc\InvalidTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use PHPStan\PhpDocParser\Parser\ParserException;
use PHPStan\PhpDocParser\Parser\PhpDocParser;
use PHPStan\PhpDocParser\Parser\TokenIterator;
use Rector\BetterPhpDocParser\Contract\PhpDocParserAwareInterface;
use Rector\BetterPhpDocParser\Contract\StringTagMatchingPhpDocNodeFactoryInterface;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\PHPUnit\PHPUnitDataProviderTagValueNode;
use RectorPrefix20210317\Symplify\PackageBuilder\Reflection\PrivatesCaller;
final class PHPUnitDataProviderDocNodeFactory implements \Rector\BetterPhpDocParser\Contract\StringTagMatchingPhpDocNodeFactoryInterface, \Rector\BetterPhpDocParser\Contract\PhpDocParserAwareInterface
{
    /**
     * @var PrivatesCaller
     */
    private $privatesCaller;
    /**
     * @var PhpDocParser
     */
    private $phpDocParser;
    public function __construct(\RectorPrefix20210317\Symplify\PackageBuilder\Reflection\PrivatesCaller $privatesCaller)
    {
        $this->privatesCaller = $privatesCaller;
    }
    /**
     * @param \PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator
     */
    public function createFromTokens($tokenIterator) : ?\PHPStan\PhpDocParser\Ast\Node
    {
        try {
            $tokenIterator->pushSavePoint();
            $phpUnitDataProviderTagValueNode = $this->parseDataProviderTagValue($tokenIterator);
            $tokenIterator->dropSavePoint();
            return $phpUnitDataProviderTagValueNode;
        } catch (\PHPStan\PhpDocParser\Parser\ParserException $parserException) {
            $tokenIterator->rollback();
            $description = $this->privatesCaller->callPrivateMethod($this->phpDocParser, 'parseOptionalDescription', [$tokenIterator]);
            $invalidTagValueNode = new \PHPStan\PhpDocParser\Ast\PhpDoc\InvalidTagValueNode($description, $parserException);
            return new \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode('', $invalidTagValueNode);
        }
    }
    /**
     * @deprecated Refactor to remove dependency on phpdoc parser
     * @param \PHPStan\PhpDocParser\Parser\PhpDocParser $phpDocParser
     */
    public function setPhpDocParser($phpDocParser) : void
    {
        $this->phpDocParser = $phpDocParser;
    }
    /**
     * @param string $tag
     */
    public function match($tag) : bool
    {
        return \strtolower($tag) === \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\PHPUnit\PHPUnitDataProviderTagValueNode::NAME;
    }
    /**
     * Override of parent private method to allow reference: https://github.com/rectorphp/rector/pull/1735
     * @param \PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator
     */
    private function parseDataProviderTagValue($tokenIterator) : \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\PHPUnit\PHPUnitDataProviderTagValueNode
    {
        $method = $this->privatesCaller->callPrivateMethod($this->phpDocParser, 'parseOptionalDescription', [$tokenIterator]);
        return new \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\PHPUnit\PHPUnitDataProviderTagValueNode($method);
    }
}
