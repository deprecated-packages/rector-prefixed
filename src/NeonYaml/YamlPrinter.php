<?php

declare (strict_types=1);
namespace Rector\Core\NeonYaml;

use _PhpScoper006a73f0e455\Symfony\Component\Yaml\Yaml;
final class YamlPrinter
{
    /**
     * @param mixed[] $yaml
     */
    public function printYamlToString(array $yaml) : string
    {
        return \_PhpScoper006a73f0e455\Symfony\Component\Yaml\Yaml::dump($yaml, 10, 4, \_PhpScoper006a73f0e455\Symfony\Component\Yaml\Yaml::DUMP_MULTI_LINE_LITERAL_BLOCK);
    }
}
