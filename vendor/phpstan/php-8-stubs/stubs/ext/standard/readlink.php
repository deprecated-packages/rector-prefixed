<?php

namespace _PhpScoper26e51eeacccf;

/* link.c */
#if defined(HAVE_SYMLINK) || defined(PHP_WIN32)
function readlink(string $path) : string|false
{
}
