<?php

namespace RectorPrefix20210423\Psr\Log;

/**
 * Describes a logger instance.
 *
 * The message MUST be a string or object implementing __toString().
 *
 * The message MAY contain placeholders in the form: {foo} where foo
 * will be replaced by the context data in key "foo".
 *
 * The context array can contain arbitrary data. The only assumption that
 * can be made by implementors is that if an Exception instance is given
 * to produce a stack trace, it MUST be in a key named "exception".
 *
 * See https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md
 * for the full interface specification.
 */
interface LoggerInterface
{
    /**
     * System is unusable.
     *
     * @param string  $message
     * @param mixed[] $context
     *
     * @return void
     */
    public function emergency($message, $context = array());
    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string  $message
     * @param mixed[] $context
     *
     * @return void
     */
    public function alert($message, $context = array());
    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string  $message
     * @param mixed[] $context
     *
     * @return void
     */
    public function critical($message, $context = array());
    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string  $message
     * @param mixed[] $context
     *
     * @return void
     */
    public function error($message, $context = array());
    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string  $message
     * @param mixed[] $context
     *
     * @return void
     */
    public function warning($message, $context = array());
    /**
     * Normal but significant events.
     *
     * @param string  $message
     * @param mixed[] $context
     *
     * @return void
     */
    public function notice($message, $context = array());
    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string  $message
     * @param mixed[] $context
     *
     * @return void
     */
    public function info($message, $context = array());
    /**
     * Detailed debug information.
     *
     * @param string  $message
     * @param mixed[] $context
     *
     * @return void
     */
    public function debug($message, $context = array());
    /**
     * Logs with an arbitrary level.
     *
     * @param mixed   $level
     * @param string  $message
     * @param mixed[] $context
     *
     * @return void
     *
     * @throws \Psr\Log\InvalidArgumentException
     */
    public function log($level, $message, $context = array());
}
