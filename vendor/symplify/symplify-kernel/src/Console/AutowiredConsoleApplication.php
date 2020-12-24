<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\SymplifyKernel\Console;

use _PhpScoper0a6b37af0871\Symfony\Component\Console\Command\Command;
/**
 * @see \Symplify\SymplifyKernel\Tests\Console\AbstractSymplifyConsoleApplication\AutowiredConsoleApplicationTest
 */
final class AutowiredConsoleApplication extends \_PhpScoper0a6b37af0871\Symplify\SymplifyKernel\Console\AbstractSymplifyConsoleApplication
{
    /**
     * @param Command[] $commands
     */
    public function __construct(array $commands, string $name = 'UNKNOWN', string $version = 'UNKNOWN')
    {
        parent::__construct($commands, $name, $version);
    }
}
