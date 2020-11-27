<?php

namespace _PhpScoperbd5d0c5f7638;

#if defined(HAVE_CHROOT) && !defined(ZTS) && ENABLE_CHROOT_FUNC
function chroot(string $directory) : bool
{
}
