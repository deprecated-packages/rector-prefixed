<?php

namespace _PhpScoper006a73f0e455;

/* link.c */
#if defined(HAVE_SYMLINK) || defined(PHP_WIN32)
function readlink(string $path) : string|false
{
}
