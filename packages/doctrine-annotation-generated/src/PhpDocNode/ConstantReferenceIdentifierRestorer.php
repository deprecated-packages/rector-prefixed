<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DoctrineAnnotationGenerated\PhpDocNode;

use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Annotation\AnnotationItemsResolver;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Annotation\AnnotationVisibilityDetector;
use _PhpScoper0a6b37af0871\Rector\DoctrineAnnotationGenerated\DataCollector\ResolvedConstantStaticCollector;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
/**
 * @see https://github.com/rectorphp/rector/pull/3275/files
 */
final class ConstantReferenceIdentifierRestorer
{
    /**
     * @var PrivatesAccessor
     */
    private $privatesAccessor;
    /**
     * @var AnnotationItemsResolver
     */
    private $annotationItemsResolver;
    /**
     * @var AnnotationVisibilityDetector
     */
    private $annotationVisibilityDetector;
    public function __construct(\_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Reflection\PrivatesAccessor $privatesAccessor, \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Annotation\AnnotationItemsResolver $annotationItemsResolver, \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Annotation\AnnotationVisibilityDetector $annotationVisibilityDetector)
    {
        $this->privatesAccessor = $privatesAccessor;
        $this->annotationItemsResolver = $annotationItemsResolver;
        $this->annotationVisibilityDetector = $annotationVisibilityDetector;
    }
    public function restoreObject(object $annotation) : void
    {
        // restore constant value back to original value
        $identifierToResolvedValues = \_PhpScoper0a6b37af0871\Rector\DoctrineAnnotationGenerated\DataCollector\ResolvedConstantStaticCollector::provide();
        if ($identifierToResolvedValues === []) {
            return;
        }
        $propertyNameToValues = $this->annotationItemsResolver->resolve($annotation);
        $isPrivate = $this->annotationVisibilityDetector->isPrivate($annotation);
        foreach ($propertyNameToValues as $propertyName => $value) {
            $originalIdentifier = $this->matchIdentifierBasedOnResolverValue($identifierToResolvedValues, $value);
            if ($originalIdentifier !== null) {
                // restore value
                if ($isPrivate) {
                    $this->privatesAccessor->setPrivateProperty($annotation, $propertyName, $originalIdentifier);
                } else {
                    $annotation->{$propertyName} = $originalIdentifier;
                }
                continue;
            }
            // nested resolved value
            if (!\is_array($value)) {
                continue;
            }
            $this->restoreNestedValue($value, $identifierToResolvedValues, $isPrivate, $annotation, $propertyName);
        }
        \_PhpScoper0a6b37af0871\Rector\DoctrineAnnotationGenerated\DataCollector\ResolvedConstantStaticCollector::clear();
    }
    /**
     * @param array<string, mixed> $identifierToResolvedValues
     * @param mixed $value
     * @return mixed|null
     */
    private function matchIdentifierBasedOnResolverValue(array $identifierToResolvedValues, $value)
    {
        foreach ($identifierToResolvedValues as $identifier => $resolvedValue) {
            if ($value !== $resolvedValue) {
                continue;
            }
            return $identifier;
        }
        return null;
    }
    /**
     * @param mixed[] $value
     * @param array<string, mixed> $identifierToResolvedValues
     */
    private function restoreNestedValue(array $value, array $identifierToResolvedValues, bool $isPrivate, object $annotation, string $propertyName) : void
    {
        foreach ($value as $key => $nestedValue) {
            $originalIdentifier = $this->matchIdentifierBasedOnResolverValue($identifierToResolvedValues, $nestedValue);
            if ($originalIdentifier === null) {
                continue;
            }
            // restore value
            if ($isPrivate) {
                $value = $this->privatesAccessor->getPrivateProperty($annotation, $propertyName);
                $value[$key] = $originalIdentifier;
                $this->privatesAccessor->setPrivateProperty($annotation, $propertyName, $value);
            } else {
                $annotation->{$propertyName}[$key] = $originalIdentifier;
            }
        }
    }
}
