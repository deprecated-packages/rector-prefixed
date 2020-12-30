<?php

declare (strict_types=1);
namespace Rector\Testing\PhpConfigPrinter;

use RectorPrefix20201230\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface;
final class YamlFileContentProvider implements \RectorPrefix20201230\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface
{
    public function setContent(string $yamlContent) : void
    {
    }
    public function getYamlContent() : string
    {
        return '';
    }
}
