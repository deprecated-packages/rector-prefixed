<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210316\Symfony\Polyfill\Util;

if (\extension_loaded('mbstring')) {
    class Binary extends \RectorPrefix20210316\Symfony\Polyfill\Util\BinaryOnFuncOverload
    {
    }
} else {
    class Binary extends \RectorPrefix20210316\Symfony\Polyfill\Util\BinaryNoFuncOverload
    {
    }
}
