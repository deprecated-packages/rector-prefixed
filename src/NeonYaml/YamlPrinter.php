<?php

declare (strict_types=1);
namespace Rector\Core\NeonYaml;

use _PhpScoperabd03f0baf05\Symfony\Component\Yaml\Yaml;
final class YamlPrinter
{
    /**
     * @param mixed[] $yaml
     */
    public function printYamlToString(array $yaml) : string
    {
        return \_PhpScoperabd03f0baf05\Symfony\Component\Yaml\Yaml::dump($yaml, 10, 4, \_PhpScoperabd03f0baf05\Symfony\Component\Yaml\Yaml::DUMP_MULTI_LINE_LITERAL_BLOCK);
    }
}
