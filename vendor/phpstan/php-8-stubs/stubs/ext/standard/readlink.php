<?php

namespace _PhpScoperbd5d0c5f7638;

/* link.c */
#if defined(HAVE_SYMLINK) || defined(PHP_WIN32)
function readlink(string $path) : string|false
{
}
