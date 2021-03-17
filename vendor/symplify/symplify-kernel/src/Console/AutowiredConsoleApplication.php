<?php

declare (strict_types=1);
namespace RectorPrefix20210317\Symplify\SymplifyKernel\Console;

use RectorPrefix20210317\Symfony\Component\Console\Command\Command;
/**
 * @see \Symplify\SymplifyKernel\Tests\Console\AbstractSymplifyConsoleApplication\AutowiredConsoleApplicationTest
 */
final class AutowiredConsoleApplication extends \RectorPrefix20210317\Symplify\SymplifyKernel\Console\AbstractSymplifyConsoleApplication
{
    /**
     * @param Command[] $commands
     * @param string $name
     * @param string $version
     */
    public function __construct($commands, $name = 'UNKNOWN', $version = 'UNKNOWN')
    {
        parent::__construct($commands, $name, $version);
    }
}
