<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocParser;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Node;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Lexer\Lexer;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\ConstExprParser;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\PhpDocParser;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\TokenIterator;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\TypeParser;
use _PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocNode;
use _PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\RequiredTagValueNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Attributes\Attribute\Attribute;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\GenericPhpDocNodeFactoryInterface;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNodeFactoryInterface;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\SpecificPhpDocNodeFactoryInterface;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocNodeFactory\ParamPhpDocNodeFactory;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocNodeFactory\PHPUnitDataProviderDocNodeFactory;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Printer\MultilineSpaceFormatPreserver;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\StartAndEnd;
use _PhpScoperb75b35f52b74\Rector\Core\Configuration\CurrentNodeProvider;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\PhpAttribute\ValueObject\TagName;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Reflection\PrivatesCaller;
/**
 * @see \Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\TagValueNodeReprintTest
 */
final class BetterPhpDocParser extends \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\PhpDocParser
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
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\TypeParser $typeParser, \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\ConstExprParser $constExprParser, \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory $attributeAwareNodeFactory, \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Printer\MultilineSpaceFormatPreserver $multilineSpaceFormatPreserver, \_PhpScoperb75b35f52b74\Rector\Core\Configuration\CurrentNodeProvider $currentNodeProvider, \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocParser\ClassAnnotationMatcher $classAnnotationMatcher, \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Lexer\Lexer $lexer, \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocParser\AnnotationContentResolver $annotationContentResolver, \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocNodeFactory\ParamPhpDocNodeFactory $paramPhpDocNodeFactory, \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocNodeFactory\PHPUnitDataProviderDocNodeFactory $phpUnitDataProviderDocNodeFactory, array $phpDocNodeFactories = [])
    {
        parent::__construct($typeParser, $constExprParser);
        $this->privatesCaller = new \_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Reflection\PrivatesCaller();
        $this->privatesAccessor = new \_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Reflection\PrivatesAccessor();
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
    public function parseString(string $docBlock) : \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode
    {
        $tokens = $this->lexer->tokenize($docBlock);
        $tokenIterator = new \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\TokenIterator($tokens);
        return parent::parse($tokenIterator);
    }
    /**
     * @return AttributeAwarePhpDocNode|PhpDocNode
     */
    public function parse(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode
    {
        $originalTokenIterator = clone $tokenIterator;
        $tokenIterator->consumeTokenType(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_OPEN_PHPDOC);
        $tokenIterator->tryConsumeTokenType(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL);
        $children = [];
        if (!$tokenIterator->isCurrentTokenType(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_PHPDOC)) {
            $children[] = $this->parseChildAndStoreItsPositions($tokenIterator);
            while ($tokenIterator->tryConsumeTokenType(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL) && !$tokenIterator->isCurrentTokenType(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_PHPDOC)) {
                $children[] = $this->parseChildAndStoreItsPositions($tokenIterator);
            }
        }
        // might be in the middle of annotations
        $tokenIterator->tryConsumeTokenType(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_PHPDOC);
        $phpDocNode = new \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode(\array_values($children));
        $docContent = $this->annotationContentResolver->resolveFromTokenIterator($originalTokenIterator);
        return $this->attributeAwareNodeFactory->createFromNode($phpDocNode, $docContent);
    }
    public function parseTag(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode
    {
        $tag = $this->resolveTag($tokenIterator);
        $phpDocTagValueNode = $this->parseTagValue($tokenIterator, $tag);
        return new \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode($tag, $phpDocTagValueNode);
    }
    public function parseTagValue(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator, string $tag) : \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
    {
        // needed for reference support in params, see https://github.com/rectorphp/rector/issues/1734
        $tagValueNode = null;
        $currentPhpNode = $this->currentNodeProvider->getNode();
        if ($currentPhpNode === null) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        $lowercasedTag = \strtolower($tag);
        if ($lowercasedTag === '@param') {
            // to prevent circular reference of this service
            $this->paramPhpDocNodeFactory->setPhpDocParser($this);
            $tagValueNode = $this->paramPhpDocNodeFactory->createFromTokens($tokenIterator);
        } elseif ($lowercasedTag === '@dataprovider') {
            $this->phpUnitDataProviderDocNodeFactory->setPhpDocParser($this);
            $tagValueNode = $this->phpUnitDataProviderDocNodeFactory->createFromTokens($tokenIterator);
        } elseif ($lowercasedTag === '@' . \_PhpScoperb75b35f52b74\Rector\PhpAttribute\ValueObject\TagName::REQUIRED) {
            $tagValueNode = new \_PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\RequiredTagValueNode();
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
    private function parseChildAndStoreItsPositions(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Node
    {
        $originalTokenIterator = clone $tokenIterator;
        $docContent = $this->annotationContentResolver->resolveFromTokenIterator($originalTokenIterator);
        $tokenStart = $this->getTokenIteratorIndex($tokenIterator);
        $phpDocNode = $this->privatesCaller->callPrivateMethod($this, 'parseChild', $tokenIterator);
        $tokenEnd = $this->resolveTokenEnd($tokenIterator);
        $startAndEnd = new \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\StartAndEnd($tokenStart, $tokenEnd);
        $attributeAwareNode = $this->attributeAwareNodeFactory->createFromNode($phpDocNode, $docContent);
        $attributeAwareNode->setAttribute(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Attributes\Attribute\Attribute::START_END, $startAndEnd);
        $possibleMultilineText = $this->multilineSpaceFormatPreserver->resolveCurrentPhpDocNodeText($attributeAwareNode);
        if ($possibleMultilineText) {
            // add original text, for keeping trimmed spaces
            $originalContent = $this->getOriginalContentFromTokenIterator($tokenIterator);
            // we try to match original content without trimmed spaces
            $currentTextPattern = '#' . \preg_quote($possibleMultilineText, '#') . '#s';
            $currentTextPattern = \_PhpScoperb75b35f52b74\Nette\Utils\Strings::replace($currentTextPattern, '#(\\s)+#', '\\s+');
            $match = \_PhpScoperb75b35f52b74\Nette\Utils\Strings::match($originalContent, $currentTextPattern);
            if (isset($match[0])) {
                $attributeAwareNode->setAttribute(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Attributes\Attribute\Attribute::ORIGINAL_CONTENT, $match[0]);
            }
        }
        return $attributeAwareNode;
    }
    private function resolveTag(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : string
    {
        $tag = $tokenIterator->currentTokenValue();
        $tokenIterator->next();
        // basic annotation
        if (\_PhpScoperb75b35f52b74\Nette\Utils\Strings::match($tag, self::TAG_REGEX)) {
            return $tag;
        }
        // is not e.g "@var "
        // join tags like "@ORM\Column" etc.
        if ($tokenIterator->currentTokenType() !== \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_IDENTIFIER) {
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
    private function matchTagToPhpDocNodeFactory(string $tag) : ?\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNodeFactoryInterface
    {
        $currentPhpNode = $this->currentNodeProvider->getNode();
        if ($currentPhpNode === null) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        $fullyQualifiedAnnotationClass = $this->classAnnotationMatcher->resolveTagFullyQualifiedName($tag, $currentPhpNode);
        return $this->phpDocNodeFactories[$fullyQualifiedAnnotationClass] ?? null;
    }
    /**
     * @return string[]
     */
    private function resolvePhpDocNodeFactoryClasses(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNodeFactoryInterface $phpDocNodeFactory) : array
    {
        if ($phpDocNodeFactory instanceof \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\SpecificPhpDocNodeFactoryInterface) {
            return $phpDocNodeFactory->getClasses();
        }
        if ($phpDocNodeFactory instanceof \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\GenericPhpDocNodeFactoryInterface) {
            return $phpDocNodeFactory->getTagValueNodeClassesToAnnotationClasses();
        }
        throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
    }
    private function getTokenIteratorIndex(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : int
    {
        return (int) $this->privatesAccessor->getPrivateProperty($tokenIterator, 'index');
    }
    private function resolveTokenEnd(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : int
    {
        $tokenEnd = $this->getTokenIteratorIndex($tokenIterator);
        return $this->adjustTokenEndToFitClassAnnotation($tokenIterator, $tokenEnd);
    }
    private function getOriginalContentFromTokenIterator(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : string
    {
        $originalTokens = $this->privatesAccessor->getPrivateProperty($tokenIterator, 'tokens');
        $originalContent = '';
        foreach ($originalTokens as $originalToken) {
            // skip opening
            if ($originalToken[1] === \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_OPEN_PHPDOC) {
                continue;
            }
            // skip closing
            if ($originalToken[1] === \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_PHPDOC) {
                continue;
            }
            if ($originalToken[1] === \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL) {
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
    private function adjustTokenEndToFitClassAnnotation(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator, int $tokenEnd) : int
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
