<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\SmartFileSystem;

/**
 * @see \Symplify\SmartFileSystem\Tests\FileSystemFilter\FileSystemFilterTest
 */
final class FileSystemFilter
{
    /**
     * @param string[] $filesAndDirectories
     * @return string[]
     */
    public function filterDirectories(array $filesAndDirectories) : array
    {
        $directories = \array_filter($filesAndDirectories, function (string $path) : bool {
            return !\is_file($path);
        });
        return \array_values($directories);
    }
    /**
     * @param string[] $filesAndDirectories
     * @return string[]
     */
    public function filterFiles(array $filesAndDirectories) : array
    {
        $files = \array_filter($filesAndDirectories, function (string $path) : bool {
            return \is_file($path);
        });
        return \array_values($files);
    }
}
