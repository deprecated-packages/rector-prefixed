<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\PhpDocParser;

use RectorPrefix20210405\Nette\Utils\Strings;
use PhpParser\Node;
use PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use Rector\BetterPhpDocParser\Attributes\Attribute\Attribute;
use Rector\BetterPhpDocParser\PhpDoc\DoctrineAnnotationTagValueNode;
use Rector\BetterPhpDocParser\PhpDocInfo\TokenIteratorFactory;
use Rector\BetterPhpDocParser\ValueObject\DoctrineAnnotation\SilentKeyMap;
use Rector\BetterPhpDocParser\ValueObject\StartAndEnd;
use Rector\Core\Configuration\CurrentNodeProvider;
use Rector\Core\Exception\ShouldNotHappenException;
final class DoctrineAnnotationDecorator
{
    /**
     * @see https://regex101.com/r/jHF5D9/1
     * @var string
     */
    private const OPEN_ANNOTATION_SUFFIX_REGEX = '#(\\{|\\,)$#';
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
    public function __construct(\Rector\Core\Configuration\CurrentNodeProvider $currentNodeProvider, \Rector\BetterPhpDocParser\PhpDocParser\ClassAnnotationMatcher $classAnnotationMatcher, \Rector\BetterPhpDocParser\PhpDocParser\StaticDoctrineAnnotationParser $staticDoctrineAnnotationParser, \Rector\BetterPhpDocParser\PhpDocInfo\TokenIteratorFactory $tokenIteratorFactory)
    {
        $this->currentNodeProvider = $currentNodeProvider;
        $this->classAnnotationMatcher = $classAnnotationMatcher;
        $this->staticDoctrineAnnotationParser = $staticDoctrineAnnotationParser;
        $this->tokenIteratorFactory = $tokenIteratorFactory;
    }
    public function decorate(\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode) : void
    {
        $currentPhpNode = $this->currentNodeProvider->getNode();
        if (!$currentPhpNode instanceof \PhpParser\Node) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        // merge split doctrine nested tags
        $this->mergeNestedDoctrineAnnotations($phpDocNode);
        foreach ($phpDocNode->children as $phpDocChildNode) {
            if (!$phpDocChildNode instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode) {
                continue;
            }
            if (!$phpDocChildNode->value instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode) {
                continue;
            }
            // known doc tag to annotation class
            $fullyQualifiedAnnotationClass = $this->classAnnotationMatcher->resolveTagFullyQualifiedName($phpDocChildNode->name, $currentPhpNode);
            // not an annotations class
            if (!\RectorPrefix20210405\Nette\Utils\Strings::contains($fullyQualifiedAnnotationClass, '\\')) {
                continue;
            }
            $genericTagValueNode = $phpDocChildNode->value;
            $nestedTokenIterator = $this->tokenIteratorFactory->create($genericTagValueNode->value);
            // mimics doctrine behavior just in phpdoc-parser syntax :)
            // https://github.com/doctrine/annotations/blob/c66f06b7c83e9a2a7523351a9d5a4b55f885e574/lib/Doctrine/Common/Annotations/DocParser.php#L742
            $values = $this->staticDoctrineAnnotationParser->resolveAnnotationMethodCall($nestedTokenIterator);
            $formerStartEnd = $genericTagValueNode->getAttribute(\Rector\BetterPhpDocParser\Attributes\Attribute\Attribute::START_END);
            $doctrineAnnotationTagValueNode = new \Rector\BetterPhpDocParser\PhpDoc\DoctrineAnnotationTagValueNode($fullyQualifiedAnnotationClass, $genericTagValueNode->value, $values, \Rector\BetterPhpDocParser\ValueObject\DoctrineAnnotation\SilentKeyMap::CLASS_NAMES_TO_SILENT_KEYS[$fullyQualifiedAnnotationClass] ?? null);
            $doctrineAnnotationTagValueNode->setAttribute(\Rector\BetterPhpDocParser\ValueObject\StartAndEnd::class, $formerStartEnd);
            $phpDocChildNode->value = $doctrineAnnotationTagValueNode;
        }
    }
    /**
     * Join token iterator with all the following nodes if nested
     */
    private function mergeNestedDoctrineAnnotations(\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode) : void
    {
        $removedKeys = [];
        foreach ($phpDocNode->children as $key => $phpDocChildNode) {
            if (\in_array($key, $removedKeys, \true)) {
                continue;
            }
            if (!$phpDocChildNode instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode) {
                continue;
            }
            if (!$phpDocChildNode->value instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode) {
                continue;
            }
            $genericTagValueNode = $phpDocChildNode->value;
            /** @var GenericTagValueNode $currentGenericTagValueNode */
            $currentGenericTagValueNode = $genericTagValueNode;
            while (\RectorPrefix20210405\Nette\Utils\Strings::match($currentGenericTagValueNode->value, self::OPEN_ANNOTATION_SUFFIX_REGEX)) {
                $nextPhpDocChildNode = $phpDocNode->children[$key + 1];
                if (!$nextPhpDocChildNode instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode) {
                    continue;
                }
                if (!$nextPhpDocChildNode->value instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode) {
                    continue;
                }
                $genericTagValueNode->value .= \PHP_EOL . $nextPhpDocChildNode->name . $nextPhpDocChildNode->value;
                /** @var StartAndEnd $currentStartAndEnd */
                $currentStartAndEnd = $phpDocChildNode->getAttribute(\Rector\BetterPhpDocParser\ValueObject\StartAndEnd::class);
                /** @var StartAndEnd $nextStartAndEnd */
                $nextStartAndEnd = $nextPhpDocChildNode->getAttribute(\Rector\BetterPhpDocParser\ValueObject\StartAndEnd::class);
                $startAndEnd = new \Rector\BetterPhpDocParser\ValueObject\StartAndEnd($currentStartAndEnd->getStart(), $nextStartAndEnd->getEnd());
                $phpDocChildNode->setAttribute(\Rector\BetterPhpDocParser\ValueObject\StartAndEnd::class, $startAndEnd);
                ++$key;
                if (!isset($phpDocNode->children[$key])) {
                    break;
                }
                $currentChildValueNode = $phpDocNode->children[$key];
                if (!$currentChildValueNode instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode) {
                    continue;
                }
                $currentGenericTagValueNode = $currentChildValueNode->value;
                if (!$currentGenericTagValueNode instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode) {
                    continue;
                }
                $removedKeys[] = $key;
            }
        }
        foreach (\array_keys($phpDocNode->children) as $key) {
            if (!\in_array($key, $removedKeys, \true)) {
                continue;
            }
            unset($phpDocNode->children[$key]);
        }
    }
}
