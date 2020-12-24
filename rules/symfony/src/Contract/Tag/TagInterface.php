<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Symfony\Contract\Tag;

interface TagInterface
{
    public function getName() : string;
    /**
     * @return array<string, mixed>
     */
    public function getData() : array;
}
