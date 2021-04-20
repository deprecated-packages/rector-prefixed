<?php

namespace RectorPrefix20210420;

class Normalizer extends \RectorPrefix20210420\Symfony\Polyfill\Intl\Normalizer\Normalizer
{
    /**
     * @deprecated since ICU 56 and removed in PHP 8
     */
    const NONE = 2;
    const FORM_D = 4;
    const FORM_KD = 8;
    const FORM_C = 16;
    const FORM_KC = 32;
    const NFD = 4;
    const NFKD = 8;
    const NFC = 16;
    const NFKC = 32;
}
\class_alias('RectorPrefix20210420\\Normalizer', 'Normalizer', \false);
