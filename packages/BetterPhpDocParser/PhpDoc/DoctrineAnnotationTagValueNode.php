<?php

declare(strict_types=1);

namespace Rector\BetterPhpDocParser\PhpDoc;

use Rector\BetterPhpDocParser\ValueObject\PhpDoc\DoctrineAnnotation\AbstractValuesAwareNode;

final class DoctrineAnnotationTagValueNode extends AbstractValuesAwareNode
{
    /**
     * @var string
     */
    private $annotationClass;

    /**
     * @param array<mixed, mixed> $values
     * @param string|null $originalContent
     * @param string|null $silentKey
     */
    public function __construct(
        // values
        string $annotationClass,
        $originalContent = null,
        array $values = [],
        $silentKey = null
    ) {
        $this->hasChanged = true;
        $this->annotationClass = $annotationClass;

        parent::__construct($values, $originalContent, $silentKey);
    }

    public function __toString(): string
    {
        if (! $this->hasChanged) {
            if ($this->originalContent === null) {
                return '';
            }

            return $this->originalContent;
        }

        if ($this->values === []) {
            if ($this->originalContent === '()') {
                // empty brackets
                return $this->originalContent;
            }

            return '';
        }

        $itemContents = $this->printValuesContent($this->values);
        return sprintf('(%s)', $itemContents);
    }

    public function getAnnotationClass(): string
    {
        return $this->annotationClass;
    }
}
