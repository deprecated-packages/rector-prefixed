<?php

declare (strict_types=1);
namespace Rector\Core\NeonYaml;

use _PhpScoperbd5d0c5f7638\Symfony\Component\Yaml\Yaml;
final class YamlPrinter
{
    /**
     * @param mixed[] $yaml
     */
    public function printYamlToString(array $yaml) : string
    {
        return \_PhpScoperbd5d0c5f7638\Symfony\Component\Yaml\Yaml::dump($yaml, 10, 4, \_PhpScoperbd5d0c5f7638\Symfony\Component\Yaml\Yaml::DUMP_MULTI_LINE_LITERAL_BLOCK);
    }
}
