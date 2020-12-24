<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\SymplifyKernel\Console;

use _PhpScoperb75b35f52b74\Symfony\Component\Console\Command\Command;
/**
 * @see \Symplify\SymplifyKernel\Tests\Console\AbstractSymplifyConsoleApplication\AutowiredConsoleApplicationTest
 */
final class AutowiredConsoleApplication extends \_PhpScoperb75b35f52b74\Symplify\SymplifyKernel\Console\AbstractSymplifyConsoleApplication
{
    /**
     * @param Command[] $commands
     */
    public function __construct(array $commands, string $name = 'UNKNOWN', string $version = 'UNKNOWN')
    {
        parent::__construct($commands, $name, $version);
    }
}
