<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\Nette\Localization;

if (\interface_exists('_PhpScoper88fe6e0ad041\\Nette\\Localization\\ITranslator')) {
    return;
}
interface ITranslator
{
    public function translate($message, $count = null);
}
