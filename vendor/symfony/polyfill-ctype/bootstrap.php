<?php

namespace RectorPrefix20201231;

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use RectorPrefix20201231\Symfony\Polyfill\Ctype as p;
if (!\function_exists('ctype_alnum')) {
    function ctype_alnum($input)
    {
        return \RectorPrefix20201231\Symfony\Polyfill\Ctype\Ctype::ctype_alnum($input);
    }
}
if (!\function_exists('ctype_alpha')) {
    function ctype_alpha($input)
    {
        return \RectorPrefix20201231\Symfony\Polyfill\Ctype\Ctype::ctype_alpha($input);
    }
}
if (!\function_exists('ctype_cntrl')) {
    function ctype_cntrl($input)
    {
        return \RectorPrefix20201231\Symfony\Polyfill\Ctype\Ctype::ctype_cntrl($input);
    }
}
if (!\function_exists('ctype_digit')) {
    function ctype_digit($input)
    {
        return \RectorPrefix20201231\Symfony\Polyfill\Ctype\Ctype::ctype_digit($input);
    }
}
if (!\function_exists('ctype_graph')) {
    function ctype_graph($input)
    {
        return \RectorPrefix20201231\Symfony\Polyfill\Ctype\Ctype::ctype_graph($input);
    }
}
if (!\function_exists('ctype_lower')) {
    function ctype_lower($input)
    {
        return \RectorPrefix20201231\Symfony\Polyfill\Ctype\Ctype::ctype_lower($input);
    }
}
if (!\function_exists('ctype_print')) {
    function ctype_print($input)
    {
        return \RectorPrefix20201231\Symfony\Polyfill\Ctype\Ctype::ctype_print($input);
    }
}
if (!\function_exists('ctype_punct')) {
    function ctype_punct($input)
    {
        return \RectorPrefix20201231\Symfony\Polyfill\Ctype\Ctype::ctype_punct($input);
    }
}
if (!\function_exists('ctype_space')) {
    function ctype_space($input)
    {
        return \RectorPrefix20201231\Symfony\Polyfill\Ctype\Ctype::ctype_space($input);
    }
}
if (!\function_exists('ctype_upper')) {
    function ctype_upper($input)
    {
        return \RectorPrefix20201231\Symfony\Polyfill\Ctype\Ctype::ctype_upper($input);
    }
}
if (!\function_exists('ctype_xdigit')) {
    function ctype_xdigit($input)
    {
        return \RectorPrefix20201231\Symfony\Polyfill\Ctype\Ctype::ctype_xdigit($input);
    }
}
