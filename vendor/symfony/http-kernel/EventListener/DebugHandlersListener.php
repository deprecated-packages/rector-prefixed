<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper88fe6e0ad041\Symfony\Component\HttpKernel\EventListener;

use _PhpScoper88fe6e0ad041\Psr\Log\LoggerInterface;
use _PhpScoper88fe6e0ad041\Symfony\Component\Console\ConsoleEvents;
use _PhpScoper88fe6e0ad041\Symfony\Component\Console\Event\ConsoleEvent;
use _PhpScoper88fe6e0ad041\Symfony\Component\Console\Output\ConsoleOutputInterface;
use _PhpScoper88fe6e0ad041\Symfony\Component\Debug\ErrorHandler as LegacyErrorHandler;
use _PhpScoper88fe6e0ad041\Symfony\Component\Debug\Exception\FatalThrowableError;
use _PhpScoper88fe6e0ad041\Symfony\Component\ErrorHandler\ErrorHandler;
use _PhpScoper88fe6e0ad041\Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use _PhpScoper88fe6e0ad041\Symfony\Component\HttpKernel\Debug\FileLinkFormatter;
use _PhpScoper88fe6e0ad041\Symfony\Component\HttpKernel\Event\KernelEvent;
use _PhpScoper88fe6e0ad041\Symfony\Component\HttpKernel\KernelEvents;
/**
 * Configures errors and exceptions handlers.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 *
 * @final since Symfony 4.4
 */
class DebugHandlersListener implements \Symfony\Component\EventDispatcher\EventSubscriberInterface
{
    private $exceptionHandler;
    private $logger;
    private $levels;
    private $throwAt;
    private $scream;
    private $fileLinkFormat;
    private $scope;
    private $firstCall = \true;
    private $hasTerminatedWithException;
    /**
     * @param callable|null                 $exceptionHandler A handler that must support \Throwable instances that will be called on Exception
     * @param array|int                     $levels           An array map of E_* to LogLevel::* or an integer bit field of E_* constants
     * @param int|null                      $throwAt          Thrown errors in a bit field of E_* constants, or null to keep the current value
     * @param bool                          $scream           Enables/disables screaming mode, where even silenced errors are logged
     * @param string|FileLinkFormatter|null $fileLinkFormat   The format for links to source files
     * @param bool                          $scope            Enables/disables scoping mode
     */
    public function __construct(callable $exceptionHandler = null, \_PhpScoper88fe6e0ad041\Psr\Log\LoggerInterface $logger = null, $levels = \E_ALL, ?int $throwAt = \E_ALL, bool $scream = \true, $fileLinkFormat = null, bool $scope = \true)
    {
        $this->exceptionHandler = $exceptionHandler;
        $this->logger = $logger;
        $this->levels = null === $levels ? \E_ALL : $levels;
        $this->throwAt = \is_int($throwAt) ? $throwAt : (null === $throwAt ? null : ($throwAt ? \E_ALL : null));
        $this->scream = $scream;
        $this->fileLinkFormat = $fileLinkFormat;
        $this->scope = $scope;
    }
    /**
     * Configures the error handler.
     */
    public function configure(\_PhpScoper88fe6e0ad041\Symfony\Component\EventDispatcher\Event $event = null)
    {
        if ($event instanceof \_PhpScoper88fe6e0ad041\Symfony\Component\Console\Event\ConsoleEvent && !\in_array(\PHP_SAPI, ['cli', 'phpdbg'], \true)) {
            return;
        }
        if (!$event instanceof \_PhpScoper88fe6e0ad041\Symfony\Component\HttpKernel\Event\KernelEvent ? !$this->firstCall : !$event->isMasterRequest()) {
            return;
        }
        $this->firstCall = $this->hasTerminatedWithException = \false;
        $handler = \set_exception_handler('var_dump');
        $handler = \is_array($handler) ? $handler[0] : null;
        \restore_exception_handler();
        if ($this->logger || null !== $this->throwAt) {
            if ($handler instanceof \_PhpScoper88fe6e0ad041\Symfony\Component\ErrorHandler\ErrorHandler || $handler instanceof \_PhpScoper88fe6e0ad041\Symfony\Component\Debug\ErrorHandler) {
                if ($this->logger) {
                    $handler->setDefaultLogger($this->logger, $this->levels);
                    if (\is_array($this->levels)) {
                        $levels = 0;
                        foreach ($this->levels as $type => $log) {
                            $levels |= $type;
                        }
                    } else {
                        $levels = $this->levels;
                    }
                    if ($this->scream) {
                        $handler->screamAt($levels);
                    }
                    if ($this->scope) {
                        $handler->scopeAt($levels & ~\E_USER_DEPRECATED & ~\E_DEPRECATED);
                    } else {
                        $handler->scopeAt(0, \true);
                    }
                    $this->logger = $this->levels = null;
                }
                if (null !== $this->throwAt) {
                    $handler->throwAt($this->throwAt, \true);
                }
            }
        }
        if (!$this->exceptionHandler) {
            if ($event instanceof \_PhpScoper88fe6e0ad041\Symfony\Component\HttpKernel\Event\KernelEvent) {
                if (\method_exists($kernel = $event->getKernel(), 'terminateWithException')) {
                    $request = $event->getRequest();
                    $hasRun =& $this->hasTerminatedWithException;
                    $this->exceptionHandler = static function (\Throwable $e) use($kernel, $request, &$hasRun) {
                        if ($hasRun) {
                            throw $e;
                        }
                        $hasRun = \true;
                        $kernel->terminateWithException($e, $request);
                    };
                }
            } elseif ($event instanceof \_PhpScoper88fe6e0ad041\Symfony\Component\Console\Event\ConsoleEvent && ($app = $event->getCommand()->getApplication())) {
                $output = $event->getOutput();
                if ($output instanceof \_PhpScoper88fe6e0ad041\Symfony\Component\Console\Output\ConsoleOutputInterface) {
                    $output = $output->getErrorOutput();
                }
                $this->exceptionHandler = static function (\Throwable $e) use($app, $output) {
                    if (\method_exists($app, 'renderThrowable')) {
                        $app->renderThrowable($e, $output);
                    } else {
                        if (!$e instanceof \Exception) {
                            $e = new \_PhpScoper88fe6e0ad041\Symfony\Component\Debug\Exception\FatalThrowableError($e);
                        }
                        $app->renderException($e, $output);
                    }
                };
            }
        }
        if ($this->exceptionHandler) {
            if ($handler instanceof \_PhpScoper88fe6e0ad041\Symfony\Component\ErrorHandler\ErrorHandler || $handler instanceof \_PhpScoper88fe6e0ad041\Symfony\Component\Debug\ErrorHandler) {
                $handler->setExceptionHandler($this->exceptionHandler);
            }
            $this->exceptionHandler = null;
        }
    }
    public static function getSubscribedEvents()
    {
        $events = [\_PhpScoper88fe6e0ad041\Symfony\Component\HttpKernel\KernelEvents::REQUEST => ['configure', 2048]];
        if (\defined('Symfony\\Component\\Console\\ConsoleEvents::COMMAND')) {
            $events[\_PhpScoper88fe6e0ad041\Symfony\Component\Console\ConsoleEvents::COMMAND] = ['configure', 2048];
        }
        return $events;
    }
}
