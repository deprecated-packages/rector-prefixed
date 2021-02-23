<?php

declare (strict_types=1);
namespace Rector\Testing\PhpConfigPrinter;

use RectorPrefix20210223\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface;
final class YamlFileContentProvider implements \RectorPrefix20210223\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface
{
    public function setContent(string $yamlContent) : void
    {
    }
    public function getYamlContent() : string
    {
        return '';
    }
}
