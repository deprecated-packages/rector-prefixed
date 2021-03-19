<?php

declare (strict_types=1);
namespace RectorPrefix20210319\Nette\Localization;

if (\interface_exists('RectorPrefix20210319\\Nette\\Localization\\ITranslator')) {
    return;
}
interface ITranslator
{
    public function translate($message, $count = null);
}
