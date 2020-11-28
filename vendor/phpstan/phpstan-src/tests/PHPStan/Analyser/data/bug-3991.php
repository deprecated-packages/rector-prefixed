<?php

namespace _PhpScoperabd03f0baf05\Bug3991;

use function PHPStan\Analyser\assertNativeType;
use function PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param \stdClass|array|null $config
     *
     * @return \stdClass
     */
    public static function email($config = null)
    {
        \PHPStan\Analyser\assertNativeType('mixed', $config);
        \PHPStan\Analyser\assertType('array|stdClass|null', $config);
        if (empty($config)) {
            \PHPStan\Analyser\assertNativeType('mixed', $config);
            \PHPStan\Analyser\assertType('array|stdClass|null', $config);
            $config = new \stdClass();
        } elseif (!(\is_array($config) || $config instanceof \stdClass)) {
            \PHPStan\Analyser\assertNativeType('mixed~array|stdClass|false|null', $config);
            \PHPStan\Analyser\assertType('*NEVER*', $config);
        }
        return new \stdClass($config);
    }
}
