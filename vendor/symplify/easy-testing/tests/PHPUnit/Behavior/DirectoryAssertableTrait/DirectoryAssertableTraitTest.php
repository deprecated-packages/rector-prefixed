<?php

declare (strict_types=1);
namespace RectorPrefix20201231\Symplify\EasyTesting\Tests\PHPUnit\Behavior\DirectoryAssertableTrait;

use RectorPrefix20201231\PHPUnit\Framework\ExpectationFailedException;
use RectorPrefix20201231\PHPUnit\Framework\TestCase;
use RectorPrefix20201231\Symplify\EasyTesting\PHPUnit\Behavior\DirectoryAssertableTrait;
use Throwable;
final class DirectoryAssertableTraitTest extends \RectorPrefix20201231\PHPUnit\Framework\TestCase
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
            $this->assertInstanceOf(\RectorPrefix20201231\PHPUnit\Framework\ExpectationFailedException::class, $throwable);
        }
    }
}
