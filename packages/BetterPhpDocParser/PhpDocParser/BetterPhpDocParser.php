<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\PhpDocParser;

use PHPStan\PhpDocParser\Ast\Node;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocChildNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use PHPStan\PhpDocParser\Lexer\Lexer;
use PHPStan\PhpDocParser\Parser\ConstExprParser;
use PHPStan\PhpDocParser\Parser\PhpDocParser;
use PHPStan\PhpDocParser\Parser\TokenIterator;
use PHPStan\PhpDocParser\Parser\TypeParser;
use Rector\BetterPhpDocParser\Attributes\Attribute\Attribute;
use Rector\BetterPhpDocParser\Contract\PhpDocParserAwareInterface;
use Rector\BetterPhpDocParser\Contract\StringTagMatchingPhpDocNodeFactoryInterface;
use Rector\BetterPhpDocParser\PhpDocInfo\TokenIteratorFactory;
use Rector\BetterPhpDocParser\PhpDocNodeMapper;
use Rector\BetterPhpDocParser\ValueObject\Parser\BetterTokenIterator;
use Rector\BetterPhpDocParser\ValueObject\StartAndEnd;
use RectorPrefix20210405\Symplify\PackageBuilder\Reflection\PrivatesCaller;
/**
 * @see \Rector\Tests\BetterPhpDocParser\PhpDocParser\TagValueNodeReprint\TagValueNodeReprintTest
 */
final class BetterPhpDocParser extends \PHPStan\PhpDocParser\Parser\PhpDocParser
{
    /**
     * @var PrivatesCaller
     */
    private $privatesCaller;
    /**
     * @var PhpDocNodeMapper
     */
    private $phpDocNodeMapper;
    /**
     * @var AnnotationContentResolver
     */
    private $annotationContentResolver;
    /**
     * @var StringTagMatchingPhpDocNodeFactoryInterface[]
     */
    private $stringTagMatchingPhpDocNodeFactories = [];
    /**
     * @var DoctrineAnnotationDecorator
     */
    private $doctrineAnnotationDecorator;
    /**
     * @var TokenIteratorFactory
     */
    private $tokenIteratorFactory;
    /**
     * @param StringTagMatchingPhpDocNodeFactoryInterface[] $stringTagMatchingPhpDocNodeFactories
     */
    public function __construct(\PHPStan\PhpDocParser\Parser\TypeParser $typeParser, \PHPStan\PhpDocParser\Parser\ConstExprParser $constExprParser, \Rector\BetterPhpDocParser\PhpDocNodeMapper $phpDocNodeMapper, \Rector\BetterPhpDocParser\PhpDocInfo\TokenIteratorFactory $tokenIteratorFactory, \Rector\BetterPhpDocParser\PhpDocParser\AnnotationContentResolver $annotationContentResolver, \Rector\BetterPhpDocParser\PhpDocParser\DoctrineAnnotationDecorator $doctrineAnnotationDecorator, array $stringTagMatchingPhpDocNodeFactories = [])
    {
        parent::__construct($typeParser, $constExprParser);
        $this->privatesCaller = new \RectorPrefix20210405\Symplify\PackageBuilder\Reflection\PrivatesCaller();
        $this->phpDocNodeMapper = $phpDocNodeMapper;
        $this->annotationContentResolver = $annotationContentResolver;
        $this->stringTagMatchingPhpDocNodeFactories = $stringTagMatchingPhpDocNodeFactories;
        $this->doctrineAnnotationDecorator = $doctrineAnnotationDecorator;
        $this->tokenIteratorFactory = $tokenIteratorFactory;
    }
    public function parse(\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode
    {
        $tokenIterator->consumeTokenType(\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_OPEN_PHPDOC);
        $tokenIterator->tryConsumeTokenType(\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL);
        $children = [];
        if (!$tokenIterator->isCurrentTokenType(\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_PHPDOC)) {
            $children[] = $this->parseChildAndStoreItsPositions($tokenIterator);
            while ($tokenIterator->tryConsumeTokenType(\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL) && !$tokenIterator->isCurrentTokenType(\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_PHPDOC)) {
                $children[] = $this->parseChildAndStoreItsPositions($tokenIterator);
            }
        }
        // might be in the middle of annotations
        $tokenIterator->tryConsumeTokenType(\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_PHPDOC);
        $phpDocNode = new \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode($children);
        // replace generic nodes with DoctrineAnnotations
        $this->doctrineAnnotationDecorator->decorate($phpDocNode);
        return $phpDocNode;
    }
    /**
     * @param BetterTokenIterator $tokenIterator
     */
    public function parseTag(\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode
    {
        $tag = $this->resolveTag($tokenIterator);
        $phpDocTagNode = $this->createPhpDocTagNodeFromStringMatch($tag, $tokenIterator);
        if ($phpDocTagNode instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode) {
            return $phpDocTagNode;
        }
        if ($phpDocTagNode instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode) {
            return new \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode($tag, $phpDocTagNode);
        }
        $phpDocTagValueNode = $this->parseTagValue($tokenIterator, $tag);
        return new \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode($tag, $phpDocTagValueNode);
    }
    /**
     * @param BetterTokenIterator $tokenIterator
     */
    public function parseTagValue(\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator, string $tag) : \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
    {
        $startPosition = $tokenIterator->currentTokenOffset();
        $tagValueNode = parent::parseTagValue($tokenIterator, $tag);
        $endPosition = $tokenIterator->currentTokenOffset();
        $startAndEnd = new \Rector\BetterPhpDocParser\ValueObject\StartAndEnd($startPosition, $endPosition);
        $tagValueNode->setAttribute(\Rector\BetterPhpDocParser\ValueObject\StartAndEnd::class, $startAndEnd);
        return $this->phpDocNodeMapper->transform($tagValueNode, $tokenIterator->print());
    }
    private function parseChildAndStoreItsPositions(\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocChildNode
    {
        $originalTokenIterator = clone $tokenIterator;
        $docContent = $this->annotationContentResolver->resolveFromTokenIterator($originalTokenIterator);
        if (!$tokenIterator instanceof \Rector\BetterPhpDocParser\ValueObject\Parser\BetterTokenIterator) {
            $tokenIterator = $this->tokenIteratorFactory->createFromTokenIterator($tokenIterator);
        }
        $tokenStart = $tokenIterator->currentPosition();
        /** @var PhpDocChildNode $phpDocNode */
        $phpDocNode = $this->privatesCaller->callPrivateMethod($this, 'parseChild', [$tokenIterator]);
        $tokenEnd = $tokenIterator->currentPosition();
        $startAndEnd = new \Rector\BetterPhpDocParser\ValueObject\StartAndEnd($tokenStart, $tokenEnd);
        $transformedPhpDocNode = $this->phpDocNodeMapper->transform($phpDocNode, $docContent);
        $transformedPhpDocNode->setAttribute(\Rector\BetterPhpDocParser\Attributes\Attribute\Attribute::START_END, $startAndEnd);
        return $transformedPhpDocNode;
    }
    private function resolveTag(\Rector\BetterPhpDocParser\ValueObject\Parser\BetterTokenIterator $tokenIterator) : string
    {
        $tag = $tokenIterator->currentTokenValue();
        $tokenIterator->next();
        // there is a space → stop
        if ($tokenIterator->isPrecededByHorizontalWhitespace()) {
            return $tag;
        }
        // is not e.g "@var "
        // join tags like "@ORM\Column" etc.
        if (!$tokenIterator->isCurrentTokenType(\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_IDENTIFIER)) {
            return $tag;
        }
        // @todo use joinUntil("(")?
        $tag .= $tokenIterator->currentTokenValue();
        $tokenIterator->next();
        return $tag;
    }
    private function createPhpDocTagNodeFromStringMatch(string $tag, \Rector\BetterPhpDocParser\ValueObject\Parser\BetterTokenIterator $tokenIterator) : ?\PHPStan\PhpDocParser\Ast\Node
    {
        foreach ($this->stringTagMatchingPhpDocNodeFactories as $stringTagMatchingPhpDocNodeFactory) {
            if (!$stringTagMatchingPhpDocNodeFactory->match($tag)) {
                continue;
            }
            if ($stringTagMatchingPhpDocNodeFactory instanceof \Rector\BetterPhpDocParser\Contract\PhpDocParserAwareInterface) {
                $stringTagMatchingPhpDocNodeFactory->setPhpDocParser($this);
            }
            return $stringTagMatchingPhpDocNodeFactory->createFromTokens($tokenIterator);
        }
        return null;
    }
}
