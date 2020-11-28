<?php

namespace _PhpScoperabd03f0baf05;

#ifdef HAVE_SIGPROCMASK
/** @param array $old_signals */
function pcntl_sigprocmask(int $mode, array $signals, &$old_signals = null) : bool
{
}
