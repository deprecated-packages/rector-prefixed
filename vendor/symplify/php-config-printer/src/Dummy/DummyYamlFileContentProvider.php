<?php

declare (strict_types=1);
namespace RectorPrefix20210121\Symplify\PhpConfigPrinter\Dummy;

use RectorPrefix20210121\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface;
final class DummyYamlFileContentProvider implements \RectorPrefix20210121\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface
{
    public function setContent(string $yamlContent) : void
    {
    }
    public function getYamlContent() : string
    {
        return '';
    }
}
