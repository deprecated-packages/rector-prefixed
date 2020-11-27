<?php

namespace _PhpScoper006a73f0e455;

#ifdef HAVE_GETPRIORITY
function pcntl_getpriority(?int $process_id = null, int $mode = \PRIO_PROCESS) : int|false
{
}
