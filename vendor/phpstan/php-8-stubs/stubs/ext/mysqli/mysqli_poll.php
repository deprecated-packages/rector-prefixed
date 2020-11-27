<?php

namespace _PhpScoperbd5d0c5f7638;

#if defined(MYSQLI_USE_MYSQLND)
function mysqli_poll(?array &$read, ?array &$write, array &$error, int $seconds, int $microseconds = 0) : int|false
{
}
