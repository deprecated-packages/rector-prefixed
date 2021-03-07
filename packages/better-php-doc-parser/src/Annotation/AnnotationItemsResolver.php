<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Annotation;

use RectorPrefix20210307\Doctrine\Common\Annotations\Annotation;
use RectorPrefix20210307\Nette\Utils\Strings;
final class AnnotationItemsResolver
{
    /**
     * @var AnnotationVisibilityDetector
     */
    private $annotationVisibilityDetector;
    public function __construct(\Rector\BetterPhpDocParser\Annotation\AnnotationVisibilityDetector $annotationVisibilityDetector)
    {
        $this->annotationVisibilityDetector = $annotationVisibilityDetector;
    }
    /**
     * @param object|Annotation|mixed[] $annotationOrItems
     * @return mixed[]
     */
    public function resolve($annotationOrItems) : array
    {
        if (\is_array($annotationOrItems)) {
            return $annotationOrItems;
        }
        // special case for private property annotations
        if ($this->annotationVisibilityDetector->isPrivate($annotationOrItems)) {
            return $this->resolvePrivatePropertyValues($annotationOrItems);
        }
        return \get_object_vars($annotationOrItems);
    }
    /**
     * @see https://ocramius.github.io/blog/fast-php-object-to-array-conversion/
     * @return mixed[]
     */
    private function resolvePrivatePropertyValues(object $object) : array
    {
        $items = [];
        foreach ((array) $object as $messedPropertyName => $value) {
            $propertyName = \RectorPrefix20210307\Nette\Utils\Strings::after($messedPropertyName, "\0", -1);
            $items[$propertyName] = $value;
        }
        return $items;
    }
}
