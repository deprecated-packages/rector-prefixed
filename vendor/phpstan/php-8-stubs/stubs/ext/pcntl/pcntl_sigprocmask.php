<?php

namespace _PhpScoper88fe6e0ad041;

#ifdef HAVE_SIGPROCMASK
/** @param array $old_signals */
function pcntl_sigprocmask(int $mode, array $signals, &$old_signals = null) : bool
{
}
