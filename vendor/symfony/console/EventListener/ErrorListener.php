<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper567b66d83109\Symfony\Component\Console\EventListener;

use _PhpScoper567b66d83109\Psr\Log\LoggerInterface;
use _PhpScoper567b66d83109\Symfony\Component\Console\ConsoleEvents;
use _PhpScoper567b66d83109\Symfony\Component\Console\Event\ConsoleErrorEvent;
use _PhpScoper567b66d83109\Symfony\Component\Console\Event\ConsoleEvent;
use _PhpScoper567b66d83109\Symfony\Component\Console\Event\ConsoleTerminateEvent;
use _PhpScoper567b66d83109\Symfony\Component\EventDispatcher\EventSubscriberInterface;
/**
 * @author James Halsall <james.t.halsall@googlemail.com>
 * @author Robin Chalas <robin.chalas@gmail.com>
 */
class ErrorListener implements \_PhpScoper567b66d83109\Symfony\Component\EventDispatcher\EventSubscriberInterface
{
    private $logger;
    public function __construct(\_PhpScoper567b66d83109\Psr\Log\LoggerInterface $logger = null)
    {
        $this->logger = $logger;
    }
    public function onConsoleError(\_PhpScoper567b66d83109\Symfony\Component\Console\Event\ConsoleErrorEvent $event)
    {
        if (null === $this->logger) {
            return;
        }
        $error = $event->getError();
        if (!($inputString = $this->getInputString($event))) {
            $this->logger->error('An error occurred while using the console. Message: "{message}"', ['exception' => $error, 'message' => $error->getMessage()]);
            return;
        }
        $this->logger->error('Error thrown while running command "{command}". Message: "{message}"', ['exception' => $error, 'command' => $inputString, 'message' => $error->getMessage()]);
    }
    public function onConsoleTerminate(\_PhpScoper567b66d83109\Symfony\Component\Console\Event\ConsoleTerminateEvent $event)
    {
        if (null === $this->logger) {
            return;
        }
        $exitCode = $event->getExitCode();
        if (0 === $exitCode) {
            return;
        }
        if (!($inputString = $this->getInputString($event))) {
            $this->logger->debug('The console exited with code "{code}"', ['code' => $exitCode]);
            return;
        }
        $this->logger->debug('Command "{command}" exited with code "{code}"', ['command' => $inputString, 'code' => $exitCode]);
    }
    public static function getSubscribedEvents()
    {
        return [\_PhpScoper567b66d83109\Symfony\Component\Console\ConsoleEvents::ERROR => ['onConsoleError', -128], \_PhpScoper567b66d83109\Symfony\Component\Console\ConsoleEvents::TERMINATE => ['onConsoleTerminate', -128]];
    }
    private static function getInputString(\_PhpScoper567b66d83109\Symfony\Component\Console\Event\ConsoleEvent $event) : ?string
    {
        $commandName = $event->getCommand() ? $event->getCommand()->getName() : null;
        $input = $event->getInput();
        if (\method_exists($input, '__toString')) {
            if ($commandName) {
                return \str_replace(["'{$commandName}'", "\"{$commandName}\""], $commandName, (string) $input);
            }
            return (string) $input;
        }
        return $commandName;
    }
}
