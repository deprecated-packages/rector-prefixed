<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NetteCodeQuality\Naming;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\Rector\Core\Util\StaticRectorStrings;
final class NetteControlNaming
{
    public function createVariableName(string $shortName) : string
    {
        $variableName = \_PhpScoper0a6b37af0871\Rector\Core\Util\StaticRectorStrings::underscoreToCamelCase($shortName);
        if (\_PhpScoper0a6b37af0871\Nette\Utils\Strings::endsWith($variableName, 'Form')) {
            return $variableName;
        }
        return $variableName . 'Control';
    }
    public function createCreateComponentClassMethodName(string $shortName) : string
    {
        return 'createComponent' . \_PhpScoper0a6b37af0871\Rector\Core\Util\StaticRectorStrings::underscoreToPascalCase($shortName);
    }
}
