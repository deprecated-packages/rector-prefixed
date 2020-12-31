<?php

namespace RectorPrefix20201231;

class Normalizer extends \RectorPrefix20201231\Symfony\Polyfill\Intl\Normalizer\Normalizer
{
    /**
     * @deprecated since ICU 56 and removed in PHP 8
     */
    const NONE = 1;
    const FORM_D = 2;
    const FORM_KD = 3;
    const FORM_C = 4;
    const FORM_KC = 5;
    const NFD = 2;
    const NFKD = 3;
    const NFC = 4;
    const NFKC = 5;
}
\class_alias('RectorPrefix20201231\\Normalizer', 'Normalizer', \false);
