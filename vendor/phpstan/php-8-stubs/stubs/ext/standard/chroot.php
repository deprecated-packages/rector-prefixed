<?php

namespace _PhpScoper006a73f0e455;

#if defined(HAVE_CHROOT) && !defined(ZTS) && ENABLE_CHROOT_FUNC
function chroot(string $directory) : bool
{
}
