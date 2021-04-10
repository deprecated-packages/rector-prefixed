<?php

declare (strict_types=1);
namespace Rector\ChangesReporting\Annotation;

use RectorPrefix20210410\Nette\Utils\Strings;
use ReflectionClass;
/**
 * @see \Rector\Tests\ChangesReporting\Annotation\AnnotationExtractorTest
 */
final class AnnotationExtractor
{
    /**
     * @param class-string<object> $className
     */
    public function extractAnnotationFromClass(string $className, string $annotation) : ?string
    {
        $reflectionClass = new \ReflectionClass($className);
        $docComment = $reflectionClass->getDocComment();
        if (!\is_string($docComment)) {
            return null;
        }
        // @see https://regex101.com/r/oYGaWU/1
        $pattern = '#' . \preg_quote($annotation, '#') . '\\s+(?<content>.*?)$#m';
        $matches = \RectorPrefix20210410\Nette\Utils\Strings::match($docComment, $pattern);
        if ($matches === \false) {
            return null;
        }
        return $matches['content'] ?? null;
    }
}