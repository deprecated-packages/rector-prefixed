<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteCodeQuality\Naming;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\Rector\Core\Util\StaticRectorStrings;
final class NetteControlNaming
{
    public function createVariableName(string $shortName) : string
    {
        $variableName = \_PhpScopere8e811afab72\Rector\Core\Util\StaticRectorStrings::underscoreToCamelCase($shortName);
        if (\_PhpScopere8e811afab72\Nette\Utils\Strings::endsWith($variableName, 'Form')) {
            return $variableName;
        }
        return $variableName . 'Control';
    }
    public function createCreateComponentClassMethodName(string $shortName) : string
    {
        return 'createComponent' . \_PhpScopere8e811afab72\Rector\Core\Util\StaticRectorStrings::underscoreToPascalCase($shortName);
    }
}
