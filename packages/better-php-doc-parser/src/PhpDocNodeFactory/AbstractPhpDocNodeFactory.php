<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocNodeFactory;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Annotation\AnnotationItemsResolver;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\AnnotationReader\NodeAnnotationReader;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocParser\AnnotationContentResolver;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\AroundSpaces;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\ShortenedObjectType;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\PHPStan\Type\ObjectTypeSpecifier;
abstract class AbstractPhpDocNodeFactory
{
    /**
     * @var string
     * @see https://regex101.com/r/548EJJ/1
     */
    private const CLASS_CONST_REGEX = '#::class#';
    /**
     * @var string
     * @see https://regex101.com/r/CsmMaz/1
     */
    private const OPENING_SPACE_REGEX = '#^\\{(?<opening_space>\\s+)#';
    /**
     * @var string
     * @see https://regex101.com/r/Rrbi3V/1
     */
    private const CLOSING_SPACE_REGEX = '#(?<closing_space>\\s+)\\}$#';
    /**
     * @var NodeAnnotationReader
     */
    protected $nodeAnnotationReader;
    /**
     * @var AnnotationContentResolver
     */
    protected $annotationContentResolver;
    /**
     * @var AnnotationItemsResolver
     */
    protected $annotationItemsResolver;
    /**
     * @var ObjectTypeSpecifier
     */
    private $objectTypeSpecifier;
    /**
     * @required
     */
    public function autowireAbstractPhpDocNodeFactory(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\AnnotationReader\NodeAnnotationReader $nodeAnnotationReader, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocParser\AnnotationContentResolver $annotationContentResolver, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Annotation\AnnotationItemsResolver $annotationItemsResolver, \_PhpScopere8e811afab72\Rector\TypeDeclaration\PHPStan\Type\ObjectTypeSpecifier $objectTypeSpecifier) : void
    {
        $this->nodeAnnotationReader = $nodeAnnotationReader;
        $this->annotationContentResolver = $annotationContentResolver;
        $this->annotationItemsResolver = $annotationItemsResolver;
        $this->objectTypeSpecifier = $objectTypeSpecifier;
    }
    protected function resolveContentFromTokenIterator(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : string
    {
        return $this->annotationContentResolver->resolveFromTokenIterator($tokenIterator);
    }
    protected function resolveFqnTargetEntity(string $targetEntity, \_PhpScopere8e811afab72\PhpParser\Node $node) : string
    {
        $targetEntity = $this->getCleanedUpTargetEntity($targetEntity);
        if (\class_exists($targetEntity)) {
            return $targetEntity;
        }
        $namespacedTargetEntity = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::NAMESPACE_NAME) . '\\' . $targetEntity;
        if (\class_exists($namespacedTargetEntity)) {
            return $namespacedTargetEntity;
        }
        $resolvedType = $this->objectTypeSpecifier->narrowToFullyQualifiedOrAliasedObjectType($node, new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($targetEntity));
        if ($resolvedType instanceof \_PhpScopere8e811afab72\Rector\PHPStan\Type\ShortenedObjectType) {
            return $resolvedType->getFullyQualifiedName();
        }
        // probably tested class
        return $targetEntity;
    }
    /**
     * Covers spaces like https://github.com/rectorphp/rector/issues/2110
     */
    protected function matchCurlyBracketAroundSpaces(string $annotationContent) : \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\AroundSpaces
    {
        $match = \_PhpScopere8e811afab72\Nette\Utils\Strings::match($annotationContent, self::OPENING_SPACE_REGEX);
        $openingSpace = $match['opening_space'] ?? '';
        $match = \_PhpScopere8e811afab72\Nette\Utils\Strings::match($annotationContent, self::CLOSING_SPACE_REGEX);
        $closingSpace = $match['closing_space'] ?? '';
        return new \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\AroundSpaces($openingSpace, $closingSpace);
    }
    private function getCleanedUpTargetEntity(string $targetEntity) : string
    {
        return \_PhpScopere8e811afab72\Nette\Utils\Strings::replace($targetEntity, self::CLASS_CONST_REGEX, '');
    }
}
