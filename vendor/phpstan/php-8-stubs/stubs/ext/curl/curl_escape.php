<?php

namespace _PhpScoper26e51eeacccf;

#if LIBCURL_VERSION_NUM >= 0x070f04 /* 7.15.4 */
function curl_escape(\CurlHandle $handle, string $string) : string|false
{
}
