<?php

namespace _PhpScoper006a73f0e455;

#if LIBCURL_VERSION_NUM >= 0x071200 /* 7.18.0 */
function curl_pause(\CurlHandle $handle, int $flags) : int
{
}
