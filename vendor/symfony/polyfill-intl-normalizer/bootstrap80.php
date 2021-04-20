<?php

namespace RectorPrefix20210420;

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use RectorPrefix20210420\Symfony\Polyfill\Intl\Normalizer as p;
if (!\function_exists('normalizer_is_normalized')) {
    /**
     * @param string|null $string
     * @param int|null $form
     */
    function normalizer_is_normalized($string, $form = \RectorPrefix20210420\Symfony\Polyfill\Intl\Normalizer\Normalizer::FORM_C) : bool
    {
        return \RectorPrefix20210420\Symfony\Polyfill\Intl\Normalizer\Normalizer::isNormalized((string) $string, (int) $form);
    }
}
if (!\function_exists('normalizer_normalize')) {
    /**
     * @return string|bool
     * @param string|null $string
     * @param int|null $form
     */
    function normalizer_normalize($string, $form = \RectorPrefix20210420\Symfony\Polyfill\Intl\Normalizer\Normalizer::FORM_C)
    {
        return \RectorPrefix20210420\Symfony\Polyfill\Intl\Normalizer\Normalizer::normalize((string) $string, (int) $form);
    }
}
