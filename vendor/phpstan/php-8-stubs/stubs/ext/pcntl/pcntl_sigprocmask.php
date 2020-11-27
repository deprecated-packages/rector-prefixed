<?php

namespace _PhpScoper006a73f0e455;

#ifdef HAVE_SIGPROCMASK
/** @param array $old_signals */
function pcntl_sigprocmask(int $mode, array $signals, &$old_signals = null) : bool
{
}
