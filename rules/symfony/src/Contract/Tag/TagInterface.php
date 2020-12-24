<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Symfony\Contract\Tag;

interface TagInterface
{
    public function getName() : string;
    /**
     * @return array<string, mixed>
     */
    public function getData() : array;
}
