<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\PhpDocNodeFactory\Doctrine\Class_;

use Doctrine\ORM\Mapping\UniqueConstraint;
use RectorPrefix20210122\Nette\Utils\Strings;
use Rector\BetterPhpDocParser\Annotation\AnnotationItemsResolver;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\UniqueConstraintTagValueNode;
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
    public function __construct(\Rector\BetterPhpDocParser\Annotation\AnnotationItemsResolver $annotationItemsResolver)
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
        $uniqueConstraintContents = \RectorPrefix20210122\Nette\Utils\Strings::matchAll($annotationContent, self::UNIQUE_CONSTRAINT_REGEX);
        $uniqueConstraintTagValueNodes = [];
        foreach ($uniqueConstraints as $key => $uniqueConstraint) {
            $subAnnotationContent = $uniqueConstraintContents[$key];
            $items = $this->annotationItemsResolver->resolve($uniqueConstraint);
            $uniqueConstraintTagValueNodes[] = new \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\UniqueConstraintTagValueNode($items, $subAnnotationContent['content'], $subAnnotationContent['tag']);
        }
        return $uniqueConstraintTagValueNodes;
    }
}
