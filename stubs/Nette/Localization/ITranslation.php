<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Nette\Localization;

if (\interface_exists('_PhpScoperabd03f0baf05\\Nette\\Localization\\ITranslator')) {
    return;
}
interface ITranslator
{
    public function translate($message, $count = null);
}
