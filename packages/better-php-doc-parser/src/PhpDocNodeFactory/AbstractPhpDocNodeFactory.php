<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\PhpDocNodeFactory;

use _PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Parser\TokenIterator;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Annotation\AnnotationItemsResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\AnnotationReader\NodeAnnotationReader;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\PhpDocParser\AnnotationContentResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\ValueObject\AroundSpaces;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType;
use _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\PHPStan\Type\ObjectTypeSpecifier;
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
    public function autowireAbstractPhpDocNodeFactory(\_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\AnnotationReader\NodeAnnotationReader $nodeAnnotationReader, \_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\PhpDocParser\AnnotationContentResolver $annotationContentResolver, \_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Annotation\AnnotationItemsResolver $annotationItemsResolver, \_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\PHPStan\Type\ObjectTypeSpecifier $objectTypeSpecifier) : void
    {
        $this->nodeAnnotationReader = $nodeAnnotationReader;
        $this->annotationContentResolver = $annotationContentResolver;
        $this->annotationItemsResolver = $annotationItemsResolver;
        $this->objectTypeSpecifier = $objectTypeSpecifier;
    }
    protected function resolveContentFromTokenIterator(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : string
    {
        return $this->annotationContentResolver->resolveFromTokenIterator($tokenIterator);
    }
    protected function resolveFqnTargetEntity(string $targetEntity, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : string
    {
        $targetEntity = $this->getCleanedUpTargetEntity($targetEntity);
        if (\class_exists($targetEntity)) {
            return $targetEntity;
        }
        $namespacedTargetEntity = $node->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::NAMESPACE_NAME) . '\\' . $targetEntity;
        if (\class_exists($namespacedTargetEntity)) {
            return $namespacedTargetEntity;
        }
        $resolvedType = $this->objectTypeSpecifier->narrowToFullyQualifiedOrAliasedObjectType($node, new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType($targetEntity));
        if ($resolvedType instanceof \_PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType) {
            return $resolvedType->getFullyQualifiedName();
        }
        // probably tested class
        return $targetEntity;
    }
    /**
     * Covers spaces like https://github.com/rectorphp/rector/issues/2110
     */
    protected function matchCurlyBracketAroundSpaces(string $annotationContent) : \_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\ValueObject\AroundSpaces
    {
        $match = \_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::match($annotationContent, self::OPENING_SPACE_REGEX);
        $openingSpace = $match['opening_space'] ?? '';
        $match = \_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::match($annotationContent, self::CLOSING_SPACE_REGEX);
        $closingSpace = $match['closing_space'] ?? '';
        return new \_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\ValueObject\AroundSpaces($openingSpace, $closingSpace);
    }
    private function getCleanedUpTargetEntity(string $targetEntity) : string
    {
        return \_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::replace($targetEntity, self::CLASS_CONST_REGEX, '');
    }
}
