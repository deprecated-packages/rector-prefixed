<?php

namespace RectorPrefix2020DecSat;

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use RectorPrefix2020DecSat\Symfony\Component\VarDumper\VarDumper;
if (!\function_exists('RectorPrefix2020DecSat\\dump')) {
    /**
     * @author Nicolas Grekas <p@tchwork.com>
     */
    function dump($var, ...$moreVars)
    {
        \RectorPrefix2020DecSat\Symfony\Component\VarDumper\VarDumper::dump($var);
        foreach ($moreVars as $v) {
            \RectorPrefix2020DecSat\Symfony\Component\VarDumper\VarDumper::dump($v);
        }
        if (1 < \func_num_args()) {
            return \func_get_args();
        }
        return $var;
    }
}
if (!\function_exists('RectorPrefix2020DecSat\\dd')) {
    function dd(...$vars)
    {
        foreach ($vars as $v) {
            \RectorPrefix2020DecSat\Symfony\Component\VarDumper\VarDumper::dump($v);
        }
        exit(1);
    }
}
