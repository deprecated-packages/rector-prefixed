<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Annotation;

final class AnnotationVisibilityDetector
{
    public function isPrivate(object $annotation) : bool
    {
        $publicPropertiesCount = \count(\get_object_vars($annotation));
        /** @noRector special way to get public property count from object */
        $propertiesCount = \count((array) $annotation);
        return $publicPropertiesCount !== $propertiesCount;
    }
}
