<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Nette\Localization;

if (\interface_exists('_PhpScoper006a73f0e455\\Nette\\Localization\\ITranslator')) {
    return;
}
interface ITranslator
{
    public function translate($message, $count = null);
}
