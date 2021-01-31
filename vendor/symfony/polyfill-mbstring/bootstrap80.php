<?php

namespace RectorPrefix20210131;

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use RectorPrefix20210131\Symfony\Polyfill\Mbstring as p;
if (!\function_exists('mb_convert_encoding')) {
    function mb_convert_encoding(array|string $string, string $to_encoding, array|string|null $from_encoding = null) : array|string|false
    {
        return \RectorPrefix20210131\Symfony\Polyfill\Mbstring\Mbstring::mb_convert_encoding($string, $to_encoding, $from_encoding);
    }
}
if (!\function_exists('mb_decode_mimeheader')) {
    function mb_decode_mimeheader(string $string) : string
    {
        return \RectorPrefix20210131\Symfony\Polyfill\Mbstring\Mbstring::mb_decode_mimeheader($string);
    }
}
if (!\function_exists('mb_encode_mimeheader')) {
    function mb_encode_mimeheader(string $string, string $charset = null, string $transfer_encoding = null, string $newline = "\r\n", int $indent = 0) : string
    {
        return \RectorPrefix20210131\Symfony\Polyfill\Mbstring\Mbstring::mb_encode_mimeheader($string, $charset, $transfer_encoding, $newline, $indent);
    }
}
if (!\function_exists('mb_decode_numericentity')) {
    function mb_decode_numericentity(string $string, array $map, string $encoding = null) : string
    {
        return \RectorPrefix20210131\Symfony\Polyfill\Mbstring\Mbstring::mb_decode_numericentity($string, $map, $encoding);
    }
}
if (!\function_exists('mb_encode_numericentity')) {
    function mb_encode_numericentity(string $string, array $map, string $encoding = null, bool $hex = \false) : string
    {
        return \RectorPrefix20210131\Symfony\Polyfill\Mbstring\Mbstring::mb_encode_numericentity($string, $map, $encoding, $hex);
    }
}
if (!\function_exists('mb_convert_case')) {
    function mb_convert_case(string $string, int $mode, string $encoding = null) : string
    {
        return \RectorPrefix20210131\Symfony\Polyfill\Mbstring\Mbstring::mb_convert_case($string, $mode, $encoding);
    }
}
if (!\function_exists('mb_internal_encoding')) {
    function mb_internal_encoding(string $encoding = null) : string|bool
    {
        return \RectorPrefix20210131\Symfony\Polyfill\Mbstring\Mbstring::mb_internal_encoding($encoding);
    }
}
if (!\function_exists('mb_language')) {
    function mb_language(string $language = null) : string|bool
    {
        return \RectorPrefix20210131\Symfony\Polyfill\Mbstring\Mbstring::mb_language($language);
    }
}
if (!\function_exists('mb_list_encodings')) {
    function mb_list_encodings() : array
    {
        return \RectorPrefix20210131\Symfony\Polyfill\Mbstring\Mbstring::mb_list_encodings();
    }
}
if (!\function_exists('mb_encoding_aliases')) {
    function mb_encoding_aliases(string $encoding) : array
    {
        return \RectorPrefix20210131\Symfony\Polyfill\Mbstring\Mbstring::mb_encoding_aliases($encoding);
    }
}
if (!\function_exists('mb_check_encoding')) {
    function mb_check_encoding(array|string|null $value = null, string $encoding = null) : bool
    {
        return \RectorPrefix20210131\Symfony\Polyfill\Mbstring\Mbstring::mb_check_encoding($value, $encoding);
    }
}
if (!\function_exists('mb_detect_encoding')) {
    function mb_detect_encoding(string $string, array|string|null $encodings = null, bool $strict = \false) : string|false
    {
        return \RectorPrefix20210131\Symfony\Polyfill\Mbstring\Mbstring::mb_detect_encoding($string, $encodings, $strict);
    }
}
if (!\function_exists('mb_detect_order')) {
    function mb_detect_order(array|string|null $encoding = null) : array|bool
    {
        return \RectorPrefix20210131\Symfony\Polyfill\Mbstring\Mbstring::mb_detect_order($encoding);
    }
}
if (!\function_exists('mb_parse_str')) {
    function mb_parse_str(string $string, &$result = array()) : bool
    {
        \parse_str($string, $result);
    }
}
if (!\function_exists('mb_strlen')) {
    function mb_strlen(string $string, string $encoding = null) : int
    {
        return \RectorPrefix20210131\Symfony\Polyfill\Mbstring\Mbstring::mb_strlen($string, $encoding);
    }
}
if (!\function_exists('mb_strpos')) {
    function mb_strpos(string $haystack, string $needle, int $offset = 0, string $encoding = null) : int|false
    {
        return \RectorPrefix20210131\Symfony\Polyfill\Mbstring\Mbstring::mb_strpos($haystack, $needle, $offset, $encoding);
    }
}
if (!\function_exists('mb_strtolower')) {
    function mb_strtolower(string $string, string $encoding = null) : string
    {
        return \RectorPrefix20210131\Symfony\Polyfill\Mbstring\Mbstring::mb_strtolower($string, $encoding);
    }
}
if (!\function_exists('mb_strtoupper')) {
    function mb_strtoupper(string $string, string $encoding = null) : string
    {
        return \RectorPrefix20210131\Symfony\Polyfill\Mbstring\Mbstring::mb_strtoupper($string, $encoding);
    }
}
if (!\function_exists('mb_substitute_character')) {
    function mb_substitute_character(string|int|null $substitute_character = null) : string|int|bool
    {
        return \RectorPrefix20210131\Symfony\Polyfill\Mbstring\Mbstring::mb_substitute_character($substitute_character);
    }
}
if (!\function_exists('mb_substr')) {
    function mb_substr(string $string, int $start, int $length = null, string $encoding = null) : string
    {
        return \RectorPrefix20210131\Symfony\Polyfill\Mbstring\Mbstring::mb_substr($string, $start, $length, $encoding);
    }
}
if (!\function_exists('mb_stripos')) {
    function mb_stripos(string $haystack, string $needle, int $offset = 0, string $encoding = null) : int|false
    {
        return \RectorPrefix20210131\Symfony\Polyfill\Mbstring\Mbstring::mb_stripos($haystack, $needle, $offset, $encoding);
    }
}
if (!\function_exists('mb_stristr')) {
    function mb_stristr(string $haystack, string $needle, bool $before_needle = \false, string $encoding = null) : string|false
    {
        return \RectorPrefix20210131\Symfony\Polyfill\Mbstring\Mbstring::mb_stristr($haystack, $needle, $before_needle, $encoding);
    }
}
if (!\function_exists('mb_strrchr')) {
    function mb_strrchr(string $haystack, string $needle, bool $before_needle = \false, string $encoding = null) : string|false
    {
        return \RectorPrefix20210131\Symfony\Polyfill\Mbstring\Mbstring::mb_strrchr($haystack, $needle, $before_needle, $encoding);
    }
}
if (!\function_exists('mb_strrichr')) {
    function mb_strrichr(string $haystack, string $needle, bool $before_needle = \false, string $encoding = null) : string|false
    {
        return \RectorPrefix20210131\Symfony\Polyfill\Mbstring\Mbstring::mb_strrichr($haystack, $needle, $before_needle, $encoding);
    }
}
if (!\function_exists('mb_strripos')) {
    function mb_strripos(string $haystack, string $needle, int $offset = 0, string $encoding = null) : int|false
    {
        return \RectorPrefix20210131\Symfony\Polyfill\Mbstring\Mbstring::mb_strripos($haystack, $needle, $offset, $encoding);
    }
}
if (!\function_exists('mb_strrpos')) {
    function mb_strrpos(string $haystack, string $needle, int $offset = 0, string $encoding = null) : int|false
    {
        return \RectorPrefix20210131\Symfony\Polyfill\Mbstring\Mbstring::mb_strrpos($haystack, $needle, $offset, $encoding);
    }
}
if (!\function_exists('mb_strstr')) {
    function mb_strstr(string $haystack, string $needle, bool $before_needle = \false, string $encoding = null) : string|false
    {
        return \RectorPrefix20210131\Symfony\Polyfill\Mbstring\Mbstring::mb_strstr($haystack, $needle, $before_needle, $encoding);
    }
}
if (!\function_exists('mb_get_info')) {
    function mb_get_info(string $type = 'all') : array|string|int|false
    {
        return \RectorPrefix20210131\Symfony\Polyfill\Mbstring\Mbstring::mb_get_info($type);
    }
}
if (!\function_exists('mb_http_output')) {
    function mb_http_output(string $encoding = null) : string|bool
    {
        return \RectorPrefix20210131\Symfony\Polyfill\Mbstring\Mbstring::mb_http_output($encoding);
    }
}
if (!\function_exists('mb_strwidth')) {
    function mb_strwidth(string $string, string $encoding = null) : int
    {
        return \RectorPrefix20210131\Symfony\Polyfill\Mbstring\Mbstring::mb_strwidth($string, $encoding);
    }
}
if (!\function_exists('mb_substr_count')) {
    function mb_substr_count(string $haystack, string $needle, string $encoding = null) : int
    {
        return \RectorPrefix20210131\Symfony\Polyfill\Mbstring\Mbstring::mb_substr_count($haystack, $needle, $encoding);
    }
}
if (!\function_exists('mb_output_handler')) {
    function mb_output_handler(string $string, int $status) : string
    {
        return \RectorPrefix20210131\Symfony\Polyfill\Mbstring\Mbstring::mb_output_handler($string, $status);
    }
}
if (!\function_exists('mb_http_input')) {
    function mb_http_input(string $type = null) : array|string|false
    {
        return \RectorPrefix20210131\Symfony\Polyfill\Mbstring\Mbstring::mb_http_input($type);
    }
}
if (!\function_exists('mb_convert_variables')) {
    function mb_convert_variables(string $to_encoding, array|string $from_encoding, mixed &$var, mixed &...$vars) : string|false
    {
        return \RectorPrefix20210131\Symfony\Polyfill\Mbstring\Mbstring::mb_convert_variables($to_encoding, $from_encoding, $var, ...$vars);
    }
}
if (!\function_exists('mb_ord')) {
    function mb_ord(string $string, string $encoding = null) : int|false
    {
        return \RectorPrefix20210131\Symfony\Polyfill\Mbstring\Mbstring::mb_ord($string, $encoding);
    }
}
if (!\function_exists('mb_chr')) {
    function mb_chr(int $codepoint, string $encoding = null) : string|false
    {
        return \RectorPrefix20210131\Symfony\Polyfill\Mbstring\Mbstring::mb_chr($codepoint, $encoding);
    }
}
if (!\function_exists('mb_scrub')) {
    function mb_scrub(string $string, string $encoding = null) : string
    {
        $encoding ??= \mb_internal_encoding();
        return \mb_convert_encoding($string, $encoding, $encoding);
    }
}
if (!\function_exists('mb_str_split')) {
    function mb_str_split(string $string, int $length = 1, string $encoding = null) : array
    {
        return \RectorPrefix20210131\Symfony\Polyfill\Mbstring\Mbstring::mb_str_split($string, $length, $encoding);
    }
}
if (\extension_loaded('mbstring')) {
    return;
}
if (!\defined('MB_CASE_UPPER')) {
    \define('MB_CASE_UPPER', 0);
}
if (!\defined('MB_CASE_LOWER')) {
    \define('MB_CASE_LOWER', 1);
}
if (!\defined('MB_CASE_TITLE')) {
    \define('MB_CASE_TITLE', 2);
}
