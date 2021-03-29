<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\PhpDocParser;

use RectorPrefix20210329\Nette\Utils\Strings;
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
use Rector\BetterPhpDocParser\Contract\MultiPhpDocNodeFactoryInterface;
use Rector\BetterPhpDocParser\Contract\PhpDocNodeFactoryInterface;
use Rector\BetterPhpDocParser\Contract\PhpDocParserAwareInterface;
use Rector\BetterPhpDocParser\Contract\SpecificPhpDocNodeFactoryInterface;
use Rector\BetterPhpDocParser\Contract\StringTagMatchingPhpDocNodeFactoryInterface;
use Rector\BetterPhpDocParser\PhpDocNodeMapper;
use Rector\BetterPhpDocParser\ValueObject\StartAndEnd;
use Rector\Core\Configuration\CurrentNodeProvider;
use Rector\Core\Exception\ShouldNotHappenException;
use RectorPrefix20210329\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use RectorPrefix20210329\Symplify\PackageBuilder\Reflection\PrivatesCaller;
/**
 * @see \Rector\Tests\BetterPhpDocParser\PhpDocParser\TagValueNodeReprint\TagValueNodeReprintTest
 */
final class BetterPhpDocParser extends \PHPStan\PhpDocParser\Parser\PhpDocParser
{
    /**
     * @var string
     * @see https://regex101.com/r/HlGzME/1
     */
    private const TAG_REGEX = '#@(var|param|return|throws|property|deprecated)#';
    /**
     * @var PhpDocNodeFactoryInterface[]
     */
    private $phpDocNodeFactories = [];
    /**
     * @var PrivatesCaller
     */
    private $privatesCaller;
    /**
     * @var PrivatesAccessor
     */
    private $privatesAccessor;
    /**
     * @var PhpDocNodeMapper
     */
    private $phpDocNodeMapper;
    /**
     * @var CurrentNodeProvider
     */
    private $currentNodeProvider;
    /**
     * @var ClassAnnotationMatcher
     */
    private $classAnnotationMatcher;
    /**
     * @var AnnotationContentResolver
     */
    private $annotationContentResolver;
    /**
     * @var StringTagMatchingPhpDocNodeFactoryInterface[]
     */
    private $stringTagMatchingPhpDocNodeFactories = [];
    /**
     * @param PhpDocNodeFactoryInterface[] $phpDocNodeFactories
     * @param StringTagMatchingPhpDocNodeFactoryInterface[] $stringTagMatchingPhpDocNodeFactories
     */
    public function __construct(\PHPStan\PhpDocParser\Parser\TypeParser $typeParser, \PHPStan\PhpDocParser\Parser\ConstExprParser $constExprParser, \Rector\BetterPhpDocParser\PhpDocNodeMapper $phpDocNodeMapper, \Rector\Core\Configuration\CurrentNodeProvider $currentNodeProvider, \Rector\BetterPhpDocParser\PhpDocParser\ClassAnnotationMatcher $classAnnotationMatcher, \Rector\BetterPhpDocParser\PhpDocParser\AnnotationContentResolver $annotationContentResolver, array $phpDocNodeFactories = [], array $stringTagMatchingPhpDocNodeFactories = [])
    {
        parent::__construct($typeParser, $constExprParser);
        $this->setPhpDocNodeFactories($phpDocNodeFactories);
        $this->privatesCaller = new \RectorPrefix20210329\Symplify\PackageBuilder\Reflection\PrivatesCaller();
        $this->privatesAccessor = new \RectorPrefix20210329\Symplify\PackageBuilder\Reflection\PrivatesAccessor();
        $this->phpDocNodeMapper = $phpDocNodeMapper;
        $this->currentNodeProvider = $currentNodeProvider;
        $this->classAnnotationMatcher = $classAnnotationMatcher;
        $this->annotationContentResolver = $annotationContentResolver;
        $this->stringTagMatchingPhpDocNodeFactories = $stringTagMatchingPhpDocNodeFactories;
    }
    public function parse(\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode
    {
        $originalTokenIterator = clone $tokenIterator;
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
        $docContent = $this->annotationContentResolver->resolveFromTokenIterator($originalTokenIterator);
        return $this->phpDocNodeMapper->transform($phpDocNode, $docContent);
    }
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
    public function parseTagValue(\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator, string $tag) : \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
    {
        $currentPhpNode = $this->currentNodeProvider->getNode();
        if (!$currentPhpNode instanceof \PhpParser\Node) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $tagValueNode = null;
        // class-annotation
        $phpDocNodeFactory = $this->matchTagToPhpDocNodeFactory($tag);
        if ($phpDocNodeFactory !== null) {
            $fullyQualifiedAnnotationClass = $this->classAnnotationMatcher->resolveTagFullyQualifiedName($tag, $currentPhpNode);
            $tagValueNode = $phpDocNodeFactory->createFromNodeAndTokens($currentPhpNode, $tokenIterator, $fullyQualifiedAnnotationClass);
        }
        $originalTokenIterator = clone $tokenIterator;
        $docContent = $this->annotationContentResolver->resolveFromTokenIterator($originalTokenIterator);
        // fallback to original parser
        if (!$tagValueNode instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode) {
            $tagValueNode = parent::parseTagValue($tokenIterator, $tag);
        }
        return $this->phpDocNodeMapper->transform($tagValueNode, $docContent);
    }
    /**
     * @param PhpDocNodeFactoryInterface[] $phpDocNodeFactories
     */
    private function setPhpDocNodeFactories(array $phpDocNodeFactories) : void
    {
        foreach ($phpDocNodeFactories as $phpDocNodeFactory) {
            $classes = $this->resolvePhpDocNodeFactoryClasses($phpDocNodeFactory);
            foreach ($classes as $class) {
                $this->phpDocNodeFactories[$class] = $phpDocNodeFactory;
            }
        }
    }
    private function parseChildAndStoreItsPositions(\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocChildNode
    {
        $originalTokenIterator = clone $tokenIterator;
        $docContent = $this->annotationContentResolver->resolveFromTokenIterator($originalTokenIterator);
        $tokenStart = $this->getTokenIteratorIndex($tokenIterator);
        /** @var PhpDocChildNode $phpDocNode */
        $phpDocNode = $this->privatesCaller->callPrivateMethod($this, 'parseChild', [$tokenIterator]);
        $tokenEnd = $this->resolveTokenEnd($tokenIterator);
        $startAndEnd = new \Rector\BetterPhpDocParser\ValueObject\StartAndEnd($tokenStart, $tokenEnd);
        $transformedPhpDocNode = $this->phpDocNodeMapper->transform($phpDocNode, $docContent);
        $transformedPhpDocNode->setAttribute(\Rector\BetterPhpDocParser\Attributes\Attribute\Attribute::START_END, $startAndEnd);
        return $transformedPhpDocNode;
    }
    private function resolveTag(\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : string
    {
        $tag = $tokenIterator->currentTokenValue();
        $tokenIterator->next();
        // basic annotation
        if (\RectorPrefix20210329\Nette\Utils\Strings::match($tag, self::TAG_REGEX)) {
            return $tag;
        }
        // is not e.g "@var "
        // join tags like "@ORM\Column" etc.
        if ($tokenIterator->currentTokenType() !== \PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_IDENTIFIER) {
            return $tag;
        }
        $oldTag = $tag;
        $tag .= $tokenIterator->currentTokenValue();
        $isTagMatchedByFactories = (bool) $this->matchTagToPhpDocNodeFactory($tag);
        if (!$isTagMatchedByFactories) {
            return $oldTag;
        }
        $tokenIterator->next();
        return $tag;
    }
    private function matchTagToPhpDocNodeFactory(string $tag) : ?\Rector\BetterPhpDocParser\Contract\PhpDocNodeFactoryInterface
    {
        $currentPhpNode = $this->currentNodeProvider->getNode();
        if (!$currentPhpNode instanceof \PhpParser\Node) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $fullyQualifiedAnnotationClass = $this->classAnnotationMatcher->resolveTagFullyQualifiedName($tag, $currentPhpNode);
        return $this->phpDocNodeFactories[$fullyQualifiedAnnotationClass] ?? null;
    }
    /**
     * @return string[]
     */
    private function resolvePhpDocNodeFactoryClasses(\Rector\BetterPhpDocParser\Contract\PhpDocNodeFactoryInterface $phpDocNodeFactory) : array
    {
        if ($phpDocNodeFactory instanceof \Rector\BetterPhpDocParser\Contract\MultiPhpDocNodeFactoryInterface) {
            return $phpDocNodeFactory->getTagValueNodeClassesToAnnotationClasses();
        }
        if ($phpDocNodeFactory instanceof \Rector\BetterPhpDocParser\Contract\SpecificPhpDocNodeFactoryInterface) {
            return $phpDocNodeFactory->getClasses();
        }
        throw new \Rector\Core\Exception\ShouldNotHappenException();
    }
    private function getTokenIteratorIndex(\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : int
    {
        return (int) $this->privatesAccessor->getPrivateProperty($tokenIterator, 'index');
    }
    private function resolveTokenEnd(\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : int
    {
        $tokenEnd = $this->getTokenIteratorIndex($tokenIterator);
        return $this->adjustTokenEndToFitClassAnnotation($tokenIterator, $tokenEnd);
    }
    /**
     * @see https://github.com/rectorphp/rector/issues/2158
     *
     * Need to find end of this bracket first, because the parseChild() skips class annotatinos
     */
    private function adjustTokenEndToFitClassAnnotation(\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator, int $tokenEnd) : int
    {
        $tokens = $this->privatesAccessor->getPrivateProperty($tokenIterator, 'tokens');
        if ($tokens[$tokenEnd][0] !== '(') {
            return $tokenEnd;
        }
        while ($tokens[$tokenEnd][0] !== ')') {
            ++$tokenEnd;
            // to prevent missing index error
            if (!isset($tokens[$tokenEnd])) {
                return --$tokenEnd;
            }
        }
        ++$tokenEnd;
        return $tokenEnd;
    }
    private function createPhpDocTagNodeFromStringMatch(string $tag, \PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : ?\PHPStan\PhpDocParser\Ast\Node
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
