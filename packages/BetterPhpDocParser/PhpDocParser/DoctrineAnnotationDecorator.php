<?php

declare(strict_types=1);

namespace Rector\BetterPhpDocParser\PhpDocParser;

use Nette\Utils\Strings;
use PhpParser\Node;
use PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use PHPStan\PhpDocParser\Lexer\Lexer;
use Rector\BetterPhpDocParser\Attributes\AttributeMirrorer;
use Rector\BetterPhpDocParser\PhpDoc\DoctrineAnnotationTagValueNode;
use Rector\BetterPhpDocParser\PhpDoc\SpacelessPhpDocTagNode;
use Rector\BetterPhpDocParser\PhpDocInfo\TokenIteratorFactory;
use Rector\BetterPhpDocParser\ValueObject\DoctrineAnnotation\SilentKeyMap;
use Rector\BetterPhpDocParser\ValueObject\PhpDocAttributeKey;
use Rector\BetterPhpDocParser\ValueObject\StartAndEnd;
use Rector\Core\Configuration\CurrentNodeProvider;
use Rector\Core\Exception\ShouldNotHappenException;

final class DoctrineAnnotationDecorator
{
    /**
     * @var CurrentNodeProvider
     */
    private $currentNodeProvider;

    /**
     * @var ClassAnnotationMatcher
     */
    private $classAnnotationMatcher;

    /**
     * @var StaticDoctrineAnnotationParser
     */
    private $staticDoctrineAnnotationParser;

    /**
     * @var TokenIteratorFactory
     */
    private $tokenIteratorFactory;

    /**
     * @var AttributeMirrorer
     */
    private $attributeMirrorer;

    public function __construct(
        CurrentNodeProvider $currentNodeProvider,
        ClassAnnotationMatcher $classAnnotationMatcher,
        StaticDoctrineAnnotationParser $staticDoctrineAnnotationParser,
        TokenIteratorFactory $tokenIteratorFactory,
        AttributeMirrorer $attributeMirrorer
    ) {
        $this->currentNodeProvider = $currentNodeProvider;
        $this->classAnnotationMatcher = $classAnnotationMatcher;
        $this->staticDoctrineAnnotationParser = $staticDoctrineAnnotationParser;
        $this->tokenIteratorFactory = $tokenIteratorFactory;
        $this->attributeMirrorer = $attributeMirrorer;
    }

    /**
     * @return void
     */
    public function decorate(PhpDocNode $phpDocNode)
    {
        $currentPhpNode = $this->currentNodeProvider->getNode();
        if (! $currentPhpNode instanceof Node) {
            throw new ShouldNotHappenException();
        }

        // merge split doctrine nested tags
        $this->mergeNestedDoctrineAnnotations($phpDocNode);

        $this->transformGenericTagValueNodesToDoctrineAnnotationTagValueNodes($phpDocNode, $currentPhpNode);
    }

    /**
     * Join token iterator with all the following nodes if nested
     * @return void
     */
    private function mergeNestedDoctrineAnnotations(PhpDocNode $phpDocNode)
    {
        $removedKeys = [];

        foreach ($phpDocNode->children as $key => $phpDocChildNode) {
            if (in_array($key, $removedKeys, true)) {
                continue;
            }

            if (! $phpDocChildNode instanceof PhpDocTagNode) {
                continue;
            }

            if (! $phpDocChildNode->value instanceof GenericTagValueNode) {
                continue;
            }

            $genericTagValueNode = $phpDocChildNode->value;

            while (isset($phpDocNode->children[$key])) {
                ++$key;

                // no more next nodes
                if (! isset($phpDocNode->children[$key])) {
                    break;
                }

                $nextPhpDocChildNode = $phpDocNode->children[$key];
                if (! $nextPhpDocChildNode instanceof PhpDocTagNode) {
                    continue;
                }

                if (! $nextPhpDocChildNode->value instanceof GenericTagValueNode) {
                    continue;
                }

                if ($this->isClosedContent($genericTagValueNode->value)) {
                    break;
                }

                $composedContent = $genericTagValueNode->value . PHP_EOL . $nextPhpDocChildNode->name . $nextPhpDocChildNode->value;
                $genericTagValueNode->value = $composedContent;

                /** @var StartAndEnd $currentStartAndEnd */
                $currentStartAndEnd = $phpDocChildNode->getAttribute(PhpDocAttributeKey::START_AND_END);

                /** @var StartAndEnd $nextStartAndEnd */
                $nextStartAndEnd = $nextPhpDocChildNode->getAttribute(PhpDocAttributeKey::START_AND_END);

                $startAndEnd = new StartAndEnd($currentStartAndEnd->getStart(), $nextStartAndEnd->getEnd());
                $phpDocChildNode->setAttribute(PhpDocAttributeKey::START_AND_END, $startAndEnd);

                $currentChildValueNode = $phpDocNode->children[$key];
                if (! $currentChildValueNode instanceof PhpDocTagNode) {
                    continue;
                }

                $currentGenericTagValueNode = $currentChildValueNode->value;
                if (! $currentGenericTagValueNode instanceof GenericTagValueNode) {
                    continue;
                }

                $removedKeys[] = $key;
            }
        }

        foreach (array_keys($phpDocNode->children) as $key) {
            if (! in_array($key, $removedKeys, true)) {
                continue;
            }

            unset($phpDocNode->children[$key]);
        }
    }

    /**
     * @return void
     */
    private function transformGenericTagValueNodesToDoctrineAnnotationTagValueNodes(
        PhpDocNode $phpDocNode,
        Node $currentPhpNode
    ) {
        foreach ($phpDocNode->children as $key => $phpDocChildNode) {
            if (! $phpDocChildNode instanceof PhpDocTagNode) {
                continue;
            }

            if (! $phpDocChildNode->value instanceof GenericTagValueNode) {
                continue;
            }

            // known doc tag to annotation class
            $fullyQualifiedAnnotationClass = $this->classAnnotationMatcher->resolveTagFullyQualifiedName(
                $phpDocChildNode->name,
                $currentPhpNode
            );

            // not an annotations class
            if (! Strings::contains($fullyQualifiedAnnotationClass, '\\')) {
                continue;
            }

            $genericTagValueNode = $phpDocChildNode->value;
            $nestedTokenIterator = $this->tokenIteratorFactory->create($genericTagValueNode->value);

            // mimics doctrine behavior just in phpdoc-parser syntax :)
            // https://github.com/doctrine/annotations/blob/c66f06b7c83e9a2a7523351a9d5a4b55f885e574/lib/Doctrine/Common/Annotations/DocParser.php#L742
            $values = $this->staticDoctrineAnnotationParser->resolveAnnotationMethodCall($nestedTokenIterator);

            $formerStartEnd = $genericTagValueNode->getAttribute(PhpDocAttributeKey::START_AND_END);

            $doctrineAnnotationTagValueNode = new DoctrineAnnotationTagValueNode(
                $fullyQualifiedAnnotationClass,
                $genericTagValueNode->value,
                $values,
                SilentKeyMap::CLASS_NAMES_TO_SILENT_KEYS[$fullyQualifiedAnnotationClass] ?? null
            );

            $doctrineAnnotationTagValueNode->setAttribute(PhpDocAttributeKey::START_AND_END, $formerStartEnd);

            $spacelessPhpDocTagNode = new SpacelessPhpDocTagNode(
                $phpDocChildNode->name,
                $doctrineAnnotationTagValueNode
            );

            $this->attributeMirrorer->mirror($phpDocChildNode, $spacelessPhpDocTagNode);
            $phpDocNode->children[$key] = $spacelessPhpDocTagNode;
        }
    }

    /**
     * This is closed block, e.g. {( ... )},
     * false on: {( ... )
     */
    private function isClosedContent(string $composedContent): bool
    {
        $composedTokenIterator = $this->tokenIteratorFactory->create($composedContent);
        $tokenCount = $composedTokenIterator->count();

        $openBracketCount = 0;
        $closeBracketCount = 0;
        if ($composedContent === '') {
            return true;
        }

        do {
            if ($composedTokenIterator->isCurrentTokenTypes([
                Lexer::TOKEN_OPEN_CURLY_BRACKET,
                Lexer::TOKEN_OPEN_PARENTHESES,
            ]) || Strings::contains($composedTokenIterator->currentTokenValue(), '(')) {
                ++$openBracketCount;
            }

            if ($composedTokenIterator->isCurrentTokenTypes([
                Lexer::TOKEN_CLOSE_CURLY_BRACKET,
                Lexer::TOKEN_CLOSE_PARENTHESES,
                // sometimes it gets mixed int    ")
            ]) || Strings::contains($composedTokenIterator->currentTokenValue(), ')')) {
                ++$closeBracketCount;
            }

            $composedTokenIterator->next();
        } while ($composedTokenIterator->currentPosition() < ($tokenCount - 1));

        return $openBracketCount === $closeBracketCount;
    }
}
