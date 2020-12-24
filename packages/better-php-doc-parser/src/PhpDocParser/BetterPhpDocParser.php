<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocParser;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Node;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Lexer\Lexer;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\ConstExprParser;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\PhpDocParser;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TypeParser;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocNode;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\RequiredTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Attributes\Attribute\Attribute;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\GenericPhpDocNodeFactoryInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNodeFactoryInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\SpecificPhpDocNodeFactoryInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocNodeFactory\ParamPhpDocNodeFactory;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocNodeFactory\PHPUnitDataProviderDocNodeFactory;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Printer\MultilineSpaceFormatPreserver;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\StartAndEnd;
use _PhpScopere8e811afab72\Rector\Core\Configuration\CurrentNodeProvider;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\PhpAttribute\ValueObject\TagName;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Reflection\PrivatesCaller;
/**
 * @see \Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\TagValueNodeReprintTest
 */
final class BetterPhpDocParser extends \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\PhpDocParser
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
     * @var Lexer
     */
    private $lexer;
    /**
     * @var AnnotationContentResolver
     */
    private $annotationContentResolver;
    /**
     * @var ParamPhpDocNodeFactory
     */
    private $paramPhpDocNodeFactory;
    /**
     * @var PHPUnitDataProviderDocNodeFactory
     */
    private $phpUnitDataProviderDocNodeFactory;
    /**
     * @param PhpDocNodeFactoryInterface[] $phpDocNodeFactories
     */
    public function __construct(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TypeParser $typeParser, \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\ConstExprParser $constExprParser, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory $attributeAwareNodeFactory, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Printer\MultilineSpaceFormatPreserver $multilineSpaceFormatPreserver, \_PhpScopere8e811afab72\Rector\Core\Configuration\CurrentNodeProvider $currentNodeProvider, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocParser\ClassAnnotationMatcher $classAnnotationMatcher, \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Lexer\Lexer $lexer, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocParser\AnnotationContentResolver $annotationContentResolver, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocNodeFactory\ParamPhpDocNodeFactory $paramPhpDocNodeFactory, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocNodeFactory\PHPUnitDataProviderDocNodeFactory $phpUnitDataProviderDocNodeFactory, array $phpDocNodeFactories = [])
    {
        parent::__construct($typeParser, $constExprParser);
        $this->privatesCaller = new \_PhpScopere8e811afab72\Symplify\PackageBuilder\Reflection\PrivatesCaller();
        $this->privatesAccessor = new \_PhpScopere8e811afab72\Symplify\PackageBuilder\Reflection\PrivatesAccessor();
        $this->attributeAwareNodeFactory = $attributeAwareNodeFactory;
        $this->multilineSpaceFormatPreserver = $multilineSpaceFormatPreserver;
        $this->currentNodeProvider = $currentNodeProvider;
        $this->classAnnotationMatcher = $classAnnotationMatcher;
        $this->lexer = $lexer;
        $this->annotationContentResolver = $annotationContentResolver;
        $this->paramPhpDocNodeFactory = $paramPhpDocNodeFactory;
        $this->phpUnitDataProviderDocNodeFactory = $phpUnitDataProviderDocNodeFactory;
        $this->setPhpDocNodeFactories($phpDocNodeFactories);
    }
    public function parseString(string $docBlock) : \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode
    {
        $tokens = $this->lexer->tokenize($docBlock);
        $tokenIterator = new \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator($tokens);
        return parent::parse($tokenIterator);
    }
    /**
     * @return AttributeAwarePhpDocNode|PhpDocNode
     */
    public function parse(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode
    {
        $originalTokenIterator = clone $tokenIterator;
        $tokenIterator->consumeTokenType(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_OPEN_PHPDOC);
        $tokenIterator->tryConsumeTokenType(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL);
        $children = [];
        if (!$tokenIterator->isCurrentTokenType(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_PHPDOC)) {
            $children[] = $this->parseChildAndStoreItsPositions($tokenIterator);
            while ($tokenIterator->tryConsumeTokenType(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL) && !$tokenIterator->isCurrentTokenType(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_PHPDOC)) {
                $children[] = $this->parseChildAndStoreItsPositions($tokenIterator);
            }
        }
        // might be in the middle of annotations
        $tokenIterator->tryConsumeTokenType(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_PHPDOC);
        $phpDocNode = new \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode(\array_values($children));
        $docContent = $this->annotationContentResolver->resolveFromTokenIterator($originalTokenIterator);
        return $this->attributeAwareNodeFactory->createFromNode($phpDocNode, $docContent);
    }
    public function parseTag(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode
    {
        $tag = $this->resolveTag($tokenIterator);
        $phpDocTagValueNode = $this->parseTagValue($tokenIterator, $tag);
        return new \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode($tag, $phpDocTagValueNode);
    }
    public function parseTagValue(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator, string $tag) : \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
    {
        // needed for reference support in params, see https://github.com/rectorphp/rector/issues/1734
        $tagValueNode = null;
        $currentPhpNode = $this->currentNodeProvider->getNode();
        if ($currentPhpNode === null) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        $lowercasedTag = \strtolower($tag);
        if ($lowercasedTag === '@param') {
            // to prevent circular reference of this service
            $this->paramPhpDocNodeFactory->setPhpDocParser($this);
            $tagValueNode = $this->paramPhpDocNodeFactory->createFromTokens($tokenIterator);
        } elseif ($lowercasedTag === '@dataprovider') {
            $this->phpUnitDataProviderDocNodeFactory->setPhpDocParser($this);
            $tagValueNode = $this->phpUnitDataProviderDocNodeFactory->createFromTokens($tokenIterator);
        } elseif ($lowercasedTag === '@' . \_PhpScopere8e811afab72\Rector\PhpAttribute\ValueObject\TagName::REQUIRED) {
            $tagValueNode = new \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\RequiredTagValueNode();
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
    private function parseChildAndStoreItsPositions(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Node
    {
        $originalTokenIterator = clone $tokenIterator;
        $docContent = $this->annotationContentResolver->resolveFromTokenIterator($originalTokenIterator);
        $tokenStart = $this->getTokenIteratorIndex($tokenIterator);
        $phpDocNode = $this->privatesCaller->callPrivateMethod($this, 'parseChild', $tokenIterator);
        $tokenEnd = $this->resolveTokenEnd($tokenIterator);
        $startAndEnd = new \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\StartAndEnd($tokenStart, $tokenEnd);
        $attributeAwareNode = $this->attributeAwareNodeFactory->createFromNode($phpDocNode, $docContent);
        $attributeAwareNode->setAttribute(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Attributes\Attribute\Attribute::START_END, $startAndEnd);
        $possibleMultilineText = $this->multilineSpaceFormatPreserver->resolveCurrentPhpDocNodeText($attributeAwareNode);
        if ($possibleMultilineText) {
            // add original text, for keeping trimmed spaces
            $originalContent = $this->getOriginalContentFromTokenIterator($tokenIterator);
            // we try to match original content without trimmed spaces
            $currentTextPattern = '#' . \preg_quote($possibleMultilineText, '#') . '#s';
            $currentTextPattern = \_PhpScopere8e811afab72\Nette\Utils\Strings::replace($currentTextPattern, '#(\\s)+#', '\\s+');
            $match = \_PhpScopere8e811afab72\Nette\Utils\Strings::match($originalContent, $currentTextPattern);
            if (isset($match[0])) {
                $attributeAwareNode->setAttribute(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Attributes\Attribute\Attribute::ORIGINAL_CONTENT, $match[0]);
            }
        }
        return $attributeAwareNode;
    }
    private function resolveTag(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : string
    {
        $tag = $tokenIterator->currentTokenValue();
        $tokenIterator->next();
        // basic annotation
        if (\_PhpScopere8e811afab72\Nette\Utils\Strings::match($tag, self::TAG_REGEX)) {
            return $tag;
        }
        // is not e.g "@var "
        // join tags like "@ORM\Column" etc.
        if ($tokenIterator->currentTokenType() !== \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_IDENTIFIER) {
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
    private function matchTagToPhpDocNodeFactory(string $tag) : ?\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNodeFactoryInterface
    {
        $currentPhpNode = $this->currentNodeProvider->getNode();
        if ($currentPhpNode === null) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        $fullyQualifiedAnnotationClass = $this->classAnnotationMatcher->resolveTagFullyQualifiedName($tag, $currentPhpNode);
        return $this->phpDocNodeFactories[$fullyQualifiedAnnotationClass] ?? null;
    }
    /**
     * @return string[]
     */
    private function resolvePhpDocNodeFactoryClasses(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNodeFactoryInterface $phpDocNodeFactory) : array
    {
        if ($phpDocNodeFactory instanceof \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\SpecificPhpDocNodeFactoryInterface) {
            return $phpDocNodeFactory->getClasses();
        }
        if ($phpDocNodeFactory instanceof \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\GenericPhpDocNodeFactoryInterface) {
            return $phpDocNodeFactory->getTagValueNodeClassesToAnnotationClasses();
        }
        throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
    }
    private function getTokenIteratorIndex(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : int
    {
        return (int) $this->privatesAccessor->getPrivateProperty($tokenIterator, 'index');
    }
    private function resolveTokenEnd(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : int
    {
        $tokenEnd = $this->getTokenIteratorIndex($tokenIterator);
        return $this->adjustTokenEndToFitClassAnnotation($tokenIterator, $tokenEnd);
    }
    private function getOriginalContentFromTokenIterator(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : string
    {
        $originalTokens = $this->privatesAccessor->getPrivateProperty($tokenIterator, 'tokens');
        $originalContent = '';
        foreach ($originalTokens as $originalToken) {
            // skip opening
            if ($originalToken[1] === \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_OPEN_PHPDOC) {
                continue;
            }
            // skip closing
            if ($originalToken[1] === \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_PHPDOC) {
                continue;
            }
            if ($originalToken[1] === \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL) {
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
    private function adjustTokenEndToFitClassAnnotation(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator, int $tokenEnd) : int
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
