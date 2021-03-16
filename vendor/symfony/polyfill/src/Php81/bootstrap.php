<?php

namespace RectorPrefix20210316;

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use RectorPrefix20210316\Symfony\Polyfill\Php81 as p;
if (\PHP_VERSION_ID >= 80100) {
    return;
}
if (!\function_exists('RectorPrefix20210316\\array_is_list')) {
    function array_is_list(array $array) : bool
    {
        return \RectorPrefix20210316\Symfony\Polyfill\Php81\Php81::array_is_list($array);
    }
}
