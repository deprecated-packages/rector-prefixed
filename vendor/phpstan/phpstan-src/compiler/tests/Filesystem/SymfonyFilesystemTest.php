<?php

declare (strict_types=1);
namespace PHPStan\Compiler\Filesystem;

use _PhpScoperbd5d0c5f7638\PHPUnit\Framework\TestCase;
final class SymfonyFilesystemTest extends \_PhpScoperbd5d0c5f7638\PHPUnit\Framework\TestCase
{
    public function testExists() : void
    {
        $inner = $this->createMock(\_PhpScoperbd5d0c5f7638\Symfony\Component\Filesystem\Filesystem::class);
        $inner->expects(self::once())->method('exists')->with('foo')->willReturn(\true);
        self::assertTrue((new \PHPStan\Compiler\Filesystem\SymfonyFilesystem($inner))->exists('foo'));
    }
    public function testRemove() : void
    {
        $inner = $this->createMock(\_PhpScoperbd5d0c5f7638\Symfony\Component\Filesystem\Filesystem::class);
        $inner->expects(self::once())->method('remove')->with('foo')->willReturn(\true);
        (new \PHPStan\Compiler\Filesystem\SymfonyFilesystem($inner))->remove('foo');
    }
    public function testMkdir() : void
    {
        $inner = $this->createMock(\_PhpScoperbd5d0c5f7638\Symfony\Component\Filesystem\Filesystem::class);
        $inner->expects(self::once())->method('mkdir')->with('foo')->willReturn(\true);
        (new \PHPStan\Compiler\Filesystem\SymfonyFilesystem($inner))->mkdir('foo');
    }
    public function testRead() : void
    {
        $inner = $this->createMock(\_PhpScoperbd5d0c5f7638\Symfony\Component\Filesystem\Filesystem::class);
        $content = (new \PHPStan\Compiler\Filesystem\SymfonyFilesystem($inner))->read(__DIR__ . '/data/composer.json');
        self::assertSame("{}\n", $content);
    }
    public function testWrite() : void
    {
        $inner = $this->createMock(\_PhpScoperbd5d0c5f7638\Symfony\Component\Filesystem\Filesystem::class);
        @\unlink(__DIR__ . '/data/test.json');
        (new \PHPStan\Compiler\Filesystem\SymfonyFilesystem($inner))->write(__DIR__ . '/data/test.json', "{}\n");
        self::assertFileExists(__DIR__ . '/data/test.json');
        self::assertFileEquals(__DIR__ . '/data/composer.json', __DIR__ . '/data/test.json');
    }
}
