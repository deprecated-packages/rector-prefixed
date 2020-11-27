<?php

namespace _PhpScoper26e51eeacccf;

#ifdef HAVE_GETPRIORITY
function pcntl_getpriority(?int $process_id = null, int $mode = \PRIO_PROCESS) : int|false
{
}
