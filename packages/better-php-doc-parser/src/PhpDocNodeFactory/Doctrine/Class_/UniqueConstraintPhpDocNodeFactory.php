<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocNodeFactory\Doctrine\Class_;

use _PhpScopere8e811afab72\Doctrine\ORM\Mapping\UniqueConstraint;
use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Annotation\AnnotationItemsResolver;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\UniqueConstraintTagValueNode;
final class UniqueConstraintPhpDocNodeFactory
{
    /**
     * @var string
     * @see https://regex101.com/r/ZBL6Uf/1
     */
    private const UNIQUE_CONSTRAINT_REGEX = '#(?<tag>@(ORM\\\\)?UniqueConstraint)\\((?<content>.*?)\\),?#si';
    /**
     * @var AnnotationItemsResolver
     */
    private $annotationItemsResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Annotation\AnnotationItemsResolver $annotationItemsResolver)
    {
        $this->annotationItemsResolver = $annotationItemsResolver;
    }
    /**
     * @param UniqueConstraint[]|null $uniqueConstraints
     * @return UniqueConstraintTagValueNode[]
     */
    public function createUniqueConstraintTagValueNodes(?array $uniqueConstraints, string $annotationContent) : array
    {
        if ($uniqueConstraints === null) {
            return [];
        }
        $uniqueConstraintContents = \_PhpScopere8e811afab72\Nette\Utils\Strings::matchAll($annotationContent, self::UNIQUE_CONSTRAINT_REGEX);
        $uniqueConstraintTagValueNodes = [];
        foreach ($uniqueConstraints as $key => $uniqueConstraint) {
            $subAnnotationContent = $uniqueConstraintContents[$key];
            $items = $this->annotationItemsResolver->resolve($uniqueConstraint);
            $uniqueConstraintTagValueNodes[] = new \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\UniqueConstraintTagValueNode($items, $subAnnotationContent['content'], $subAnnotationContent['tag']);
        }
        return $uniqueConstraintTagValueNodes;
    }
}
