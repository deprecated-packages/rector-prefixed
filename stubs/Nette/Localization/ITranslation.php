<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Nette\Localization;

if (\interface_exists('_PhpScopera143bcca66cb\\Nette\\Localization\\ITranslator')) {
    return;
}
interface ITranslator
{
    public function translate($message, $count = null);
}
