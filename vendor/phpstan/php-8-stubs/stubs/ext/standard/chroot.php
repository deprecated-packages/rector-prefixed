<?php

namespace _PhpScopera143bcca66cb;

#if defined(HAVE_CHROOT) && !defined(ZTS) && ENABLE_CHROOT_FUNC
function chroot(string $directory) : bool
{
}
