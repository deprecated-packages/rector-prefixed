<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\String;

if (!\function_exists(u::class)) {
    /**
     * @param string|null $string
     */
    function u($string = ''): UnicodeString
    {
        return new UnicodeString($string ?? '');
    }
}

if (!\function_exists(b::class)) {
    /**
     * @param string|null $string
     */
    function b($string = ''): ByteString
    {
        return new ByteString($string ?? '');
    }
}

if (!\function_exists(s::class)) {
    /**
     * @return UnicodeString|ByteString
     * @param string|null $string
     */
    function s($string = ''): AbstractString
    {
        $string = $string ?? '';

        return preg_match('//u', $string) ? new UnicodeString($string) : new ByteString($string);
    }
}
