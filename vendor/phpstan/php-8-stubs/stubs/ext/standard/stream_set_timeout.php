<?php

namespace _PhpScoper88fe6e0ad041;

#if HAVE_SYS_TIME_H || defined(PHP_WIN32)
/** @param resource $stream */
function stream_set_timeout($stream, int $seconds, int $microseconds = 0) : bool
{
}
