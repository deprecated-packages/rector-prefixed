<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\PhpDocParser;

use RectorPrefix20210124\Nette\Utils\Strings;
use PHPStan\PhpDocParser\Ast\Node;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use PHPStan\PhpDocParser\Lexer\Lexer;
use PHPStan\PhpDocParser\Parser\ConstExprParser;
use PHPStan\PhpDocParser\Parser\PhpDocParser;
use PHPStan\PhpDocParser\Parser\TokenIterator;
use PHPStan\PhpDocParser\Parser\TypeParser;
use Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocNode;
use Rector\AttributeAwarePhpDoc\Ast\PhpDoc\RequiredTagValueNode;
use Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory;
use Rector\BetterPhpDocParser\Attributes\Attribute\Attribute;
use Rector\BetterPhpDocParser\Contract\GenericPhpDocNodeFactoryInterface;
use Rector\BetterPhpDocParser\Contract\PhpDocNodeFactoryInterface;
use Rector\BetterPhpDocParser\Contract\SpecificPhpDocNodeFactoryInterface;
use Rector\BetterPhpDocParser\PhpDocNodeFactory\PHPUnitDataProviderDocNodeFactory;
use Rector\BetterPhpDocParser\Printer\MultilineSpaceFormatPreserver;
use Rector\BetterPhpDocParser\ValueObject\StartAndEnd;
use Rector\Core\Configuration\CurrentNodeProvider;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\PhpAttribute\ValueObject\TagName;
use RectorPrefix20210124\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use RectorPrefix20210124\Symplify\PackageBuilder\Reflection\PrivatesCaller;
/**
 * @see \Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\TagValueNodeReprintTest
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
     * @var AttributeAwareNodeFactory
     */
    private $attributeAwareNodeFactory;
    /**
     * @var MultilineSpaceFormatPreserver
     */
    private $multilineSpaceFormatPreserver;
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
     * @var PHPUnitDataProviderDocNodeFactory
     */
    private $phpUnitDataProviderDocNodeFactory;
    /**
     * @param PhpDocNodeFactoryInterface[] $phpDocNodeFactories
     */
    public function __construct(\PHPStan\PhpDocParser\Parser\TypeParser $typeParser, \PHPStan\PhpDocParser\Parser\ConstExprParser $constExprParser, \Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory $attributeAwareNodeFactory, \Rector\BetterPhpDocParser\Printer\MultilineSpaceFormatPreserver $multilineSpaceFormatPreserver, \Rector\Core\Configuration\CurrentNodeProvider $currentNodeProvider, \Rector\BetterPhpDocParser\PhpDocParser\ClassAnnotationMatcher $classAnnotationMatcher, \Rector\BetterPhpDocParser\PhpDocParser\AnnotationContentResolver $annotationContentResolver, \Rector\BetterPhpDocParser\PhpDocNodeFactory\PHPUnitDataProviderDocNodeFactory $phpUnitDataProviderDocNodeFactory, array $phpDocNodeFactories = [])
    {
        parent::__construct($typeParser, $constExprParser);
        $this->privatesCaller = new \RectorPrefix20210124\Symplify\PackageBuilder\Reflection\PrivatesCaller();
        $this->privatesAccessor = new \RectorPrefix20210124\Symplify\PackageBuilder\Reflection\PrivatesAccessor();
        $this->attributeAwareNodeFactory = $attributeAwareNodeFactory;
        $this->multilineSpaceFormatPreserver = $multilineSpaceFormatPreserver;
        $this->currentNodeProvider = $currentNodeProvider;
        $this->classAnnotationMatcher = $classAnnotationMatcher;
        $this->annotationContentResolver = $annotationContentResolver;
        $this->phpUnitDataProviderDocNodeFactory = $phpUnitDataProviderDocNodeFactory;
        $this->setPhpDocNodeFactories($phpDocNodeFactories);
    }
    /**
     * @return AttributeAwarePhpDocNode|PhpDocNode
     */
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
        $phpDocNode = new \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode(\array_values($children));
        $docContent = $this->annotationContentResolver->resolveFromTokenIterator($originalTokenIterator);
        return $this->attributeAwareNodeFactory->createFromNode($phpDocNode, $docContent);
    }
    public function parseTag(\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode
    {
        $tag = $this->resolveTag($tokenIterator);
        $phpDocTagValueNode = $this->parseTagValue($tokenIterator, $tag);
        return new \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode($tag, $phpDocTagValueNode);
    }
    public function parseTagValue(\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator, string $tag) : \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
    {
        // needed for reference support in params, see https://github.com/rectorphp/rector/issues/1734
        $tagValueNode = null;
        $currentPhpNode = $this->currentNodeProvider->getNode();
        if (!$currentPhpNode instanceof \PhpParser\Node) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $lowercasedTag = \strtolower($tag);
        if ($lowercasedTag === '@dataprovider') {
            $this->phpUnitDataProviderDocNodeFactory->setPhpDocParser($this);
            $tagValueNode = $this->phpUnitDataProviderDocNodeFactory->createFromTokens($tokenIterator);
        } elseif ($lowercasedTag === '@' . \Rector\PhpAttribute\ValueObject\TagName::REQUIRED) {
            $tagValueNode = new \Rector\AttributeAwarePhpDoc\Ast\PhpDoc\RequiredTagValueNode();
        } else {
            // class-annotation
            $phpDocNodeFactory = $this->matchTagToPhpDocNodeFactory($tag);
            if ($phpDocNodeFactory !== null) {
                $fullyQualifiedAnnotationClass = $this->classAnnotationMatcher->resolveTagFullyQualifiedName($tag, $currentPhpNode);
                $tagValueNode = $phpDocNodeFactory->createFromNodeAndTokens($currentPhpNode, $tokenIterator, $fullyQualifiedAnnotationClass);
            }
        }
        $originalTokenIterator = clone $tokenIterator;
        $docContent = $this->annotationContentResolver->resolveFromTokenIterator($originalTokenIterator);
        // fallback to original parser
        if ($tagValueNode === null) {
            $tagValueNode = parent::parseTagValue($tokenIterator, $tag);
        }
        return $this->attributeAwareNodeFactory->createFromNode($tagValueNode, $docContent);
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
    private function parseChildAndStoreItsPositions(\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : \PHPStan\PhpDocParser\Ast\Node
    {
        $originalTokenIterator = clone $tokenIterator;
        $docContent = $this->annotationContentResolver->resolveFromTokenIterator($originalTokenIterator);
        $tokenStart = $this->getTokenIteratorIndex($tokenIterator);
        $phpDocNode = $this->privatesCaller->callPrivateMethod($this, 'parseChild', [$tokenIterator]);
        $tokenEnd = $this->resolveTokenEnd($tokenIterator);
        $startAndEnd = new \Rector\BetterPhpDocParser\ValueObject\StartAndEnd($tokenStart, $tokenEnd);
        $attributeAwareNode = $this->attributeAwareNodeFactory->createFromNode($phpDocNode, $docContent);
        $attributeAwareNode->setAttribute(\Rector\BetterPhpDocParser\Attributes\Attribute\Attribute::START_END, $startAndEnd);
        $possibleMultilineText = $this->multilineSpaceFormatPreserver->resolveCurrentPhpDocNodeText($attributeAwareNode);
        if ($possibleMultilineText) {
            // add original text, for keeping trimmed spaces
            $originalContent = $this->getOriginalContentFromTokenIterator($tokenIterator);
            // we try to match original content without trimmed spaces
            $currentTextPattern = '#' . \preg_quote($possibleMultilineText, '#') . '#s';
            $currentTextPattern = \RectorPrefix20210124\Nette\Utils\Strings::replace($currentTextPattern, '#(\\s)+#', '\\s+');
            $match = \RectorPrefix20210124\Nette\Utils\Strings::match($originalContent, $currentTextPattern);
            if (isset($match[0])) {
                $attributeAwareNode->setAttribute(\Rector\BetterPhpDocParser\Attributes\Attribute\Attribute::ORIGINAL_CONTENT, $match[0]);
            }
        }
        return $attributeAwareNode;
    }
    private function resolveTag(\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : string
    {
        $tag = $tokenIterator->currentTokenValue();
        $tokenIterator->next();
        // basic annotation
        if (\RectorPrefix20210124\Nette\Utils\Strings::match($tag, self::TAG_REGEX)) {
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
        if ($phpDocNodeFactory instanceof \Rector\BetterPhpDocParser\Contract\SpecificPhpDocNodeFactoryInterface) {
            return $phpDocNodeFactory->getClasses();
        }
        if ($phpDocNodeFactory instanceof \Rector\BetterPhpDocParser\Contract\GenericPhpDocNodeFactoryInterface) {
            return $phpDocNodeFactory->getTagValueNodeClassesToAnnotationClasses();
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
    private function getOriginalContentFromTokenIterator(\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : string
    {
        $originalTokens = $this->privatesAccessor->getPrivateProperty($tokenIterator, 'tokens');
        $originalContent = '';
        foreach ($originalTokens as $originalToken) {
            // skip opening
            if ($originalToken[1] === \PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_OPEN_PHPDOC) {
                continue;
            }
            // skip closing
            if ($originalToken[1] === \PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_PHPDOC) {
                continue;
            }
            if ($originalToken[1] === \PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL) {
                $originalToken[0] = \PHP_EOL;
            }
            $originalContent .= $originalToken[0];
        }
        return \trim($originalContent);
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
}
