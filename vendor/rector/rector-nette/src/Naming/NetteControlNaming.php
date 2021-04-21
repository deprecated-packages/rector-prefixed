<?php

declare(strict_types=1);

namespace Rector\Nette\Naming;

use Nette\Utils\Strings;
use Stringy\Stringy;

final class NetteControlNaming
{
    public function createVariableName(string $shortName): string
    {
        $stringy = new Stringy($shortName);
        $variableName = (string) $stringy->camelize();

        if (Strings::endsWith($variableName, 'Form')) {
            return $variableName;
        }

        return $variableName . 'Control';
    }

    public function createCreateComponentClassMethodName(string $shortName): string
    {
        $stringy = new Stringy($shortName);
        $componentName = (string) $stringy->upperCamelize();

        return 'createComponent' . $componentName;
    }
}
