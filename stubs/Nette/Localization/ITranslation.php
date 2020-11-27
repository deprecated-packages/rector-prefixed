<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Nette\Localization;

if (\interface_exists('_PhpScoperbd5d0c5f7638\\Nette\\Localization\\ITranslator')) {
    return;
}
interface ITranslator
{
    public function translate($message, $count = null);
}
