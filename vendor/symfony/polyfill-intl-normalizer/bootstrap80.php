<?php

namespace RectorPrefix20210130;

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use RectorPrefix20210130\Symfony\Polyfill\Intl\Normalizer as p;
if (!\function_exists('normalizer_is_normalized')) {
    function normalizer_is_normalized(string $string, int $form = \RectorPrefix20210130\Symfony\Polyfill\Intl\Normalizer\Normalizer::FORM_C) : bool
    {
        return \RectorPrefix20210130\Symfony\Polyfill\Intl\Normalizer\Normalizer::isNormalized($string, $form);
    }
}
if (!\function_exists('normalizer_normalize')) {
    function normalizer_normalize(string $string, int $form = \RectorPrefix20210130\Symfony\Polyfill\Intl\Normalizer\Normalizer::FORM_C) : string|false
    {
        return \RectorPrefix20210130\Symfony\Polyfill\Intl\Normalizer\Normalizer::normalize($string, $form);
    }
}
