<?php

declare (strict_types=1);
namespace RectorPrefix20210320\Nette\Localization;

if (\interface_exists('RectorPrefix20210320\\Nette\\Localization\\ITranslator')) {
    return;
}
interface ITranslator
{
    public function translate($message, $count = null);
}
