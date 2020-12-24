<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocNodeFactory\Doctrine\Class_;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Annotation\AnnotationItemsResolver;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\IndexTagValueNode;
final class IndexPhpDocNodeFactory
{
    /**
     * @var string
     * @see https://regex101.com/r/wkjfUt/1
     */
    private const INDEX_REGEX = '#(?<tag>@(ORM\\\\)?Index)\\((?<content>.*?)\\),?#si';
    /**
     * @var AnnotationItemsResolver
     */
    private $annotationItemsResolver;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Annotation\AnnotationItemsResolver $annotationItemsResolver)
    {
        $this->annotationItemsResolver = $annotationItemsResolver;
    }
    /**
     * @param mixed[]|null $indexes
     * @return IndexTagValueNode[]
     */
    public function createIndexTagValueNodes(?array $indexes, string $annotationContent) : array
    {
        if ($indexes === null) {
            return [];
        }
        $indexContents = \_PhpScoperb75b35f52b74\Nette\Utils\Strings::matchAll($annotationContent, self::INDEX_REGEX);
        $indexTagValueNodes = [];
        foreach ($indexes as $key => $index) {
            $currentContent = $indexContents[$key];
            $items = $this->annotationItemsResolver->resolve($index);
            $indexTagValueNodes[] = new \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\IndexTagValueNode($items, $currentContent['content'], $currentContent['tag']);
        }
        return $indexTagValueNodes;
    }
}
