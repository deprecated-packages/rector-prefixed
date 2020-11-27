<?php

namespace _PhpScoperbd5d0c5f7638;

#ifdef HAVE_GETPRIORITY
function pcntl_getpriority(?int $process_id = null, int $mode = \PRIO_PROCESS) : int|false
{
}
