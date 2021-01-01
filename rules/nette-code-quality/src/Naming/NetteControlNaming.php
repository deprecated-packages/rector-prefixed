<?php

declare (strict_types=1);
namespace Rector\NetteCodeQuality\Naming;

use RectorPrefix20210101\Nette\Utils\Strings;
use Rector\Core\Util\StaticRectorStrings;
final class NetteControlNaming
{
    public function createVariableName(string $shortName) : string
    {
        $variableName = \Rector\Core\Util\StaticRectorStrings::underscoreToCamelCase($shortName);
        if (\RectorPrefix20210101\Nette\Utils\Strings::endsWith($variableName, 'Form')) {
            return $variableName;
        }
        return $variableName . 'Control';
    }
    public function createCreateComponentClassMethodName(string $shortName) : string
    {
        return 'createComponent' . \Rector\Core\Util\StaticRectorStrings::underscoreToPascalCase($shortName);
    }
}
