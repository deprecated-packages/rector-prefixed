<?php

declare (strict_types=1);
namespace RectorPrefix20210321\Symfony\Component\Translation;

if (\class_exists('Symfony\\Component\\Translation\\Translator')) {
    return;
}
class Translator implements \RectorPrefix20210321\Symfony\Component\Translation\TranslatorInterface
{
}
