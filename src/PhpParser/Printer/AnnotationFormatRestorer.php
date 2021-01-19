<?php

declare (strict_types=1);
namespace Rector\Core\PhpParser\Printer;

final class AnnotationFormatRestorer
{
    /**
     * @var ContentPatcher
     */
    private $contentPatcher;
    public function __construct(\Rector\Core\PhpParser\Printer\ContentPatcher $contentPatcher)
    {
        $this->contentPatcher = $contentPatcher;
    }
    public function restore(string $contentOriginal, string $content) : string
    {
        $content = $this->contentPatcher->rollbackValidAnnotation($contentOriginal, $content, \Rector\Core\PhpParser\Printer\ContentPatcher::VALID_ANNOTATION_STRING_REGEX, \Rector\Core\PhpParser\Printer\ContentPatcher::INVALID_ANNOTATION_STRING_REGEX);
        $content = $this->contentPatcher->rollbackValidAnnotation($contentOriginal, $content, \Rector\Core\PhpParser\Printer\ContentPatcher::VALID_ANNOTATION_ROUTE_REGEX, \Rector\Core\PhpParser\Printer\ContentPatcher::INVALID_ANNOTATION_ROUTE_REGEX);
        $content = $this->contentPatcher->rollbackValidAnnotation($contentOriginal, $content, \Rector\Core\PhpParser\Printer\ContentPatcher::VALID_ANNOTATION_COMMENT_REGEX, \Rector\Core\PhpParser\Printer\ContentPatcher::INVALID_ANNOTATION_COMMENT_REGEX);
        $content = $this->contentPatcher->rollbackValidAnnotation($contentOriginal, $content, \Rector\Core\PhpParser\Printer\ContentPatcher::VALID_ANNOTATION_CONSTRAINT_REGEX, \Rector\Core\PhpParser\Printer\ContentPatcher::INVALID_ANNOTATION_CONSTRAINT_REGEX);
        $content = $this->contentPatcher->rollbackValidAnnotation($contentOriginal, $content, \Rector\Core\PhpParser\Printer\ContentPatcher::VALID_ANNOTATION_ROUTE_OPTION_REGEX, \Rector\Core\PhpParser\Printer\ContentPatcher::INVALID_ANNOTATION_ROUTE_OPTION_REGEX);
        $content = $this->contentPatcher->rollbackValidAnnotation($contentOriginal, $content, \Rector\Core\PhpParser\Printer\ContentPatcher::VALID_ANNOTATION_ROUTE_LOCALIZATION_REGEX, \Rector\Core\PhpParser\Printer\ContentPatcher::INVALID_ANNOTATION_ROUTE_LOCALIZATION_REGEX);
        $content = $this->contentPatcher->rollbackValidAnnotation($contentOriginal, $content, \Rector\Core\PhpParser\Printer\ContentPatcher::VALID_ANNOTATION_VAR_RETURN_EXPLICIT_FORMAT_REGEX, \Rector\Core\PhpParser\Printer\ContentPatcher::INVALID_ANNOTATION_VAR_RETURN_EXPLICIT_FORMAT_REGEX);
        return $this->contentPatcher->rollbackDuplicateComment($contentOriginal, $content);
    }
}
