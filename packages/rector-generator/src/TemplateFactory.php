<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\RectorGenerator;

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
