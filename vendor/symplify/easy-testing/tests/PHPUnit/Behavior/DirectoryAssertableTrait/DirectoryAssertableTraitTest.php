<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\EasyTesting\Tests\PHPUnit\Behavior\DirectoryAssertableTrait;

use _PhpScoperb75b35f52b74\PHPUnit\Framework\ExpectationFailedException;
use _PhpScoperb75b35f52b74\PHPUnit\Framework\TestCase;
use _PhpScoperb75b35f52b74\Symplify\EasyTesting\PHPUnit\Behavior\DirectoryAssertableTrait;
use Throwable;
final class DirectoryAssertableTraitTest extends \_PhpScoperb75b35f52b74\PHPUnit\Framework\TestCase
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
            $this->assertInstanceOf(\_PhpScoperb75b35f52b74\PHPUnit\Framework\ExpectationFailedException::class, $throwable);
        }
    }
}
