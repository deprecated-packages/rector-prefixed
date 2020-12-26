<?php

namespace RectorPrefix2020DecSat;

class Normalizer extends \RectorPrefix2020DecSat\Symfony\Polyfill\Intl\Normalizer\Normalizer
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
\class_alias('RectorPrefix2020DecSat\\Normalizer', 'Normalizer', \false);
