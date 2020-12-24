<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\Contract;

interface YamlFileContentProviderInterface
{
    public function setContent(string $yamlContent) : void;
    public function getYamlContent() : string;
}
