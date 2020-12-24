<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\RectorGenerator;

final class TemplateFactory
{
    /**
     * @param mixed[] $variables
     */
    public function create(string $content, array $variables) : string
    {
        return \str_replace(\array_keys($variables), \array_values($variables), $content);
    }
}
