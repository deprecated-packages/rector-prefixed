<?php

namespace _PhpScoper88fe6e0ad041;

#endif
#ifdef HAVE_STRUCT_SIGINFO_T
#if defined(HAVE_SIGWAITINFO) && defined(HAVE_SIGTIMEDWAIT)
/** @param array $info */
function pcntl_sigwaitinfo(array $signals, &$info = []) : int|false
{
}
