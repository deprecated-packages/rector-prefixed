<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\PhpDocNodeFactory;

use RectorPrefix20210227\Nette\Utils\Strings;
use PhpParser\Node;
use PHPStan\PhpDocParser\Parser\TokenIterator;
use PHPStan\Type\ObjectType;
use Rector\BetterPhpDocParser\Annotation\AnnotationItemsResolver;
use Rector\BetterPhpDocParser\AnnotationReader\NodeAnnotationReader;
use Rector\BetterPhpDocParser\PhpDocParser\AnnotationContentResolver;
use Rector\BetterPhpDocParser\ValueObject\AroundSpaces;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType;
use Rector\TypeDeclaration\PHPStan\Type\ObjectTypeSpecifier;
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
    public function autowireAbstractPhpDocNodeFactory(\Rector\BetterPhpDocParser\AnnotationReader\NodeAnnotationReader $nodeAnnotationReader, \Rector\BetterPhpDocParser\PhpDocParser\AnnotationContentResolver $annotationContentResolver, \Rector\BetterPhpDocParser\Annotation\AnnotationItemsResolver $annotationItemsResolver, \Rector\TypeDeclaration\PHPStan\Type\ObjectTypeSpecifier $objectTypeSpecifier) : void
    {
        $this->nodeAnnotationReader = $nodeAnnotationReader;
        $this->annotationContentResolver = $annotationContentResolver;
        $this->annotationItemsResolver = $annotationItemsResolver;
        $this->objectTypeSpecifier = $objectTypeSpecifier;
    }
    protected function resolveContentFromTokenIterator(\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : string
    {
        return $this->annotationContentResolver->resolveFromTokenIterator($tokenIterator);
    }
    protected function resolveFqnTargetEntity(string $targetEntity, \PhpParser\Node $node) : string
    {
        $targetEntity = $this->getCleanedUpTargetEntity($targetEntity);
        if (\class_exists($targetEntity)) {
            return $targetEntity;
        }
        $namespacedTargetEntity = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::NAMESPACE_NAME) . '\\' . $targetEntity;
        if (\class_exists($namespacedTargetEntity)) {
            return $namespacedTargetEntity;
        }
        $resolvedType = $this->objectTypeSpecifier->narrowToFullyQualifiedOrAliasedObjectType($node, new \PHPStan\Type\ObjectType($targetEntity));
        if ($resolvedType instanceof \Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType) {
            return $resolvedType->getFullyQualifiedName();
        }
        // probably tested class
        return $targetEntity;
    }
    /**
     * Covers spaces like https://github.com/rectorphp/rector/issues/2110
     */
    protected function matchCurlyBracketAroundSpaces(string $annotationContent) : \Rector\BetterPhpDocParser\ValueObject\AroundSpaces
    {
        $match = \RectorPrefix20210227\Nette\Utils\Strings::match($annotationContent, self::OPENING_SPACE_REGEX);
        $openingSpace = $match['opening_space'] ?? '';
        $match = \RectorPrefix20210227\Nette\Utils\Strings::match($annotationContent, self::CLOSING_SPACE_REGEX);
        $closingSpace = $match['closing_space'] ?? '';
        return new \Rector\BetterPhpDocParser\ValueObject\AroundSpaces($openingSpace, $closingSpace);
    }
    private function getCleanedUpTargetEntity(string $targetEntity) : string
    {
        return \RectorPrefix20210227\Nette\Utils\Strings::replace($targetEntity, self::CLASS_CONST_REGEX, '');
    }
}
