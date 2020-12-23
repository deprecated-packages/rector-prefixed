<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\EasyTesting\Tests\PHPUnit\Behavior\DirectoryAssertableTrait;

use _PhpScoper0a2ac50786fa\PHPUnit\Framework\ExpectationFailedException;
use _PhpScoper0a2ac50786fa\PHPUnit\Framework\TestCase;
use _PhpScoper0a2ac50786fa\Symplify\EasyTesting\PHPUnit\Behavior\DirectoryAssertableTrait;
use Throwable;
final class DirectoryAssertableTraitTest extends \_PhpScoper0a2ac50786fa\PHPUnit\Framework\TestCase
{
    use DirectoryAssertableTrait;
    public function testSuccess() : void
    {
        $this->assertDirectoryEquals(__DIR__ . '/Fixture/first_directory', __DIR__ . '/Fixture/second_directory');
    }
    public function testFail() : void
    {
        $throwable = null;
        try {
            $this->assertDirectoryEquals(__DIR__ . '/Fixture/first_directory', __DIR__ . '/Fixture/third_directory');
        } catch (\Throwable $throwable) {
        } finally {
            $this->assertInstanceOf(\_PhpScoper0a2ac50786fa\PHPUnit\Framework\ExpectationFailedException::class, $throwable);
        }
    }
}
