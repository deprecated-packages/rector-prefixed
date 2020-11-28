<?php

declare (strict_types=1);
namespace PHPStan\Compiler\Console;

use PHPStan\Compiler\Filesystem\Filesystem;
use PHPStan\Compiler\Process\Process;
use PHPStan\Compiler\Process\ProcessFactory;
use _PhpScoperabd03f0baf05\PHPUnit\Framework\TestCase;
use _PhpScoperabd03f0baf05\Symfony\Component\Console\Application;
use _PhpScoperabd03f0baf05\Symfony\Component\Console\Tester\CommandTester;
final class CompileCommandTest extends \_PhpScoperabd03f0baf05\PHPUnit\Framework\TestCase
{
    public function testCommand() : void
    {
        $filesystem = $this->createMock(\PHPStan\Compiler\Filesystem\Filesystem::class);
        $filesystem->expects(self::once())->method('read')->with('bar/composer.json')->willReturn('{"name":"phpstan/phpstan-src","replace":{"phpstan/phpstan": "self.version"},"require":{"php":"^7.4"},"require-dev":1,"autoload-dev":2,"autoload":{"psr-4":{"PHPStan\\\\":[3]}}}');
        $filesystem->expects(self::once())->method('write')->with('bar/composer.json', <<<EOT
{
    "name": "phpstan/phpstan",
    "require": {
        "php": "^7.1"
    },
    "require-dev": 1,
    "autoload-dev": 2,
    "autoload": {
        "psr-4": {
            "PHPStan\\\\": "src/"
        }
    }
}
EOT
);
        $process = $this->createMock(\PHPStan\Compiler\Process\Process::class);
        $processFactory = $this->createMock(\PHPStan\Compiler\Process\ProcessFactory::class);
        $processFactory->expects(self::at(0))->method('setOutput');
        $processFactory->expects(self::at(1))->method('create')->with(['php', 'box.phar', 'compile', '--no-parallel'], 'foo')->willReturn($process);
        $application = new \_PhpScoperabd03f0baf05\Symfony\Component\Console\Application();
        $application->add(new \PHPStan\Compiler\Console\CompileCommand($filesystem, $processFactory, 'foo', 'bar'));
        $command = $application->find('phpstan:compile');
        $commandTester = new \_PhpScoperabd03f0baf05\Symfony\Component\Console\Tester\CommandTester($command);
        $exitCode = $commandTester->execute(['command' => $command->getName()]);
        self::assertSame(0, $exitCode);
    }
}
