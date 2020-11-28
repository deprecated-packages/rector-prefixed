<?php

namespace _PhpScoperabd03f0baf05;

#ifdef HAVE_GETPRIORITY
function pcntl_getpriority(?int $process_id = null, int $mode = \PRIO_PROCESS) : int|false
{
}
