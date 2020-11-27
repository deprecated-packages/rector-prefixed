<?php

namespace _PhpScoper26e51eeacccf;

#ifdef HAVE_SIGPROCMASK
/** @param array $old_signals */
function pcntl_sigprocmask(int $mode, array $signals, &$old_signals = null) : bool
{
}
