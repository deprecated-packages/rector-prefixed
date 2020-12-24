<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\Extensions;

use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette;
/**
 * Constant definitions.
 */
final class ConstantsExtension extends \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\CompilerExtension
{
    public function loadConfiguration()
    {
        foreach ($this->getConfig() as $name => $value) {
            $this->initialization->addBody('define(?, ?);', [$name, $value]);
        }
    }
}
