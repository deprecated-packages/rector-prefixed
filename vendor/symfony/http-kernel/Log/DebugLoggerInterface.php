<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScopera143bcca66cb\Symfony\Component\HttpKernel\Log;

use _PhpScopera143bcca66cb\Symfony\Component\HttpFoundation\Request;
/**
 * DebugLoggerInterface.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
interface DebugLoggerInterface
{
    /**
     * Returns an array of logs.
     *
     * A log is an array with the following mandatory keys:
     * timestamp, message, priority, and priorityName.
     * It can also have an optional context key containing an array.
     *
     * @param Request|null $request The request to get logs for
     *
     * @return array An array of logs
     */
    public function getLogs();
    /**
     * Returns the number of errors.
     *
     * @param Request|null $request The request to count logs for
     *
     * @return int The number of errors
     */
    public function countErrors();
    /**
     * Removes all log records.
     */
    public function clear();
}
