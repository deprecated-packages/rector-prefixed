<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Symfony\Contract\Tag;

interface TagInterface
{
    public function getName() : string;
    /**
     * @return array<string, mixed>
     */
    public function getData() : array;
}
