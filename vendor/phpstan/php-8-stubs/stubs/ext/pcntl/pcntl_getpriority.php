<?php

namespace _PhpScoper88fe6e0ad041;

#ifdef HAVE_GETPRIORITY
function pcntl_getpriority(?int $process_id = null, int $mode = \PRIO_PROCESS) : int|false
{
}
