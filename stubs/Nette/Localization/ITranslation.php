<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\Nette\Localization;

if (\interface_exists('_PhpScoper26e51eeacccf\\Nette\\Localization\\ITranslator')) {
    return;
}
interface ITranslator
{
    public function translate($message, $count = null);
}
