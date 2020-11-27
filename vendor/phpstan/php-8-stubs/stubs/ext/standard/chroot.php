<?php

namespace _PhpScoper88fe6e0ad041;

#if defined(HAVE_CHROOT) && !defined(ZTS) && ENABLE_CHROOT_FUNC
function chroot(string $directory) : bool
{
}
