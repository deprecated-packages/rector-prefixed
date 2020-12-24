<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocNodeFactory\Doctrine\Class_;

use _PhpScoperb75b35f52b74\Doctrine\ORM\Mapping\UniqueConstraint;
use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Annotation\AnnotationItemsResolver;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\UniqueConstraintTagValueNode;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Annotation\AnnotationItemsResolver $annotationItemsResolver)
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
        $uniqueConstraintContents = \_PhpScoperb75b35f52b74\Nette\Utils\Strings::matchAll($annotationContent, self::UNIQUE_CONSTRAINT_REGEX);
        $uniqueConstraintTagValueNodes = [];
        foreach ($uniqueConstraints as $key => $uniqueConstraint) {
            $subAnnotationContent = $uniqueConstraintContents[$key];
            $items = $this->annotationItemsResolver->resolve($uniqueConstraint);
            $uniqueConstraintTagValueNodes[] = new \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\UniqueConstraintTagValueNode($items, $subAnnotationContent['content'], $subAnnotationContent['tag']);
        }
        return $uniqueConstraintTagValueNodes;
    }
}
