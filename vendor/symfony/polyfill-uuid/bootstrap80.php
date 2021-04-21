<?php

namespace RectorPrefix20210421;

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use RectorPrefix20210421\Symfony\Polyfill\Uuid as p;
if (!\defined('UUID_VARIANT_NCS')) {
    \define('UUID_VARIANT_NCS', 0);
}
if (!\defined('UUID_VARIANT_DCE')) {
    \define('UUID_VARIANT_DCE', 1);
}
if (!\defined('UUID_VARIANT_MICROSOFT')) {
    \define('UUID_VARIANT_MICROSOFT', 2);
}
if (!\defined('UUID_VARIANT_OTHER')) {
    \define('UUID_VARIANT_OTHER', 3);
}
if (!\defined('UUID_TYPE_DEFAULT')) {
    \define('UUID_TYPE_DEFAULT', 0);
}
if (!\defined('UUID_TYPE_TIME')) {
    \define('UUID_TYPE_TIME', 1);
}
if (!\defined('UUID_TYPE_MD5')) {
    \define('UUID_TYPE_MD5', 3);
}
if (!\defined('UUID_TYPE_DCE')) {
    \define('UUID_TYPE_DCE', 4);
    // Deprecated alias
}
if (!\defined('UUID_TYPE_NAME')) {
    \define('UUID_TYPE_NAME', 1);
    // Deprecated alias
}
if (!\defined('UUID_TYPE_RANDOM')) {
    \define('UUID_TYPE_RANDOM', 4);
}
if (!\defined('UUID_TYPE_SHA1')) {
    \define('UUID_TYPE_SHA1', 5);
}
if (!\defined('UUID_TYPE_NULL')) {
    \define('UUID_TYPE_NULL', -1);
}
if (!\defined('UUID_TYPE_INVALID')) {
    \define('UUID_TYPE_INVALID', -42);
}
if (!\function_exists('uuid_create')) {
    /**
     * @param int|null $uuid_type
     */
    function uuid_create($uuid_type = \UUID_TYPE_DEFAULT) : string
    {
        return \RectorPrefix20210421\Symfony\Polyfill\Uuid\Uuid::uuid_create((int) $uuid_type);
    }
}
if (!\function_exists('uuid_generate_md5')) {
    /**
     * @param string|null $uuid_ns
     * @param string|null $name
     */
    function uuid_generate_md5($uuid_ns, $name) : string
    {
        return \RectorPrefix20210421\Symfony\Polyfill\Uuid\Uuid::uuid_generate_md5((string) $uuid_ns, (string) $name);
    }
}
if (!\function_exists('uuid_generate_sha1')) {
    /**
     * @param string|null $uuid_ns
     * @param string|null $name
     */
    function uuid_generate_sha1($uuid_ns, $name) : string
    {
        return \RectorPrefix20210421\Symfony\Polyfill\Uuid\Uuid::uuid_generate_sha1((string) $uuid_ns, (string) $name);
    }
}
if (!\function_exists('uuid_is_valid')) {
    /**
     * @param string|null $uuid
     */
    function uuid_is_valid($uuid) : bool
    {
        return \RectorPrefix20210421\Symfony\Polyfill\Uuid\Uuid::uuid_is_valid((string) $uuid);
    }
}
if (!\function_exists('uuid_compare')) {
    /**
     * @param string|null $uuid1
     * @param string|null $uuid2
     */
    function uuid_compare($uuid1, $uuid2) : int
    {
        return \RectorPrefix20210421\Symfony\Polyfill\Uuid\Uuid::uuid_compare((string) $uuid1, (string) $uuid2);
    }
}
if (!\function_exists('uuid_is_null')) {
    /**
     * @param string|null $uuid
     */
    function uuid_is_null($uuid) : bool
    {
        return \RectorPrefix20210421\Symfony\Polyfill\Uuid\Uuid::uuid_is_null((string) $uuid);
    }
}
if (!\function_exists('uuid_type')) {
    /**
     * @param string|null $uuid
     */
    function uuid_type($uuid) : int
    {
        return \RectorPrefix20210421\Symfony\Polyfill\Uuid\Uuid::uuid_type((string) $uuid);
    }
}
if (!\function_exists('uuid_variant')) {
    /**
     * @param string|null $uuid
     */
    function uuid_variant($uuid) : int
    {
        return \RectorPrefix20210421\Symfony\Polyfill\Uuid\Uuid::uuid_variant((string) $uuid);
    }
}
if (!\function_exists('uuid_time')) {
    /**
     * @param string|null $uuid
     */
    function uuid_time($uuid) : int
    {
        return \RectorPrefix20210421\Symfony\Polyfill\Uuid\Uuid::uuid_time((string) $uuid);
    }
}
if (!\function_exists('uuid_mac')) {
    /**
     * @param string|null $uuid
     */
    function uuid_mac($uuid) : string
    {
        return \RectorPrefix20210421\Symfony\Polyfill\Uuid\Uuid::uuid_mac((string) $uuid);
    }
}
if (!\function_exists('uuid_parse')) {
    /**
     * @param string|null $uuid
     */
    function uuid_parse($uuid) : string
    {
        return \RectorPrefix20210421\Symfony\Polyfill\Uuid\Uuid::uuid_parse((string) $uuid);
    }
}
if (!\function_exists('uuid_unparse')) {
    /**
     * @param string|null $uuid
     */
    function uuid_unparse($uuid) : string
    {
        return \RectorPrefix20210421\Symfony\Polyfill\Uuid\Uuid::uuid_unparse((string) $uuid);
    }
}
