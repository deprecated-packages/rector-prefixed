<?php

namespace _PhpScopera143bcca66cb;

#if defined(PHP_WIN32) || HAVE_DNS_SEARCH_FUNC
function dns_check_record(string $hostname, string $type = "MX") : bool
{
}
