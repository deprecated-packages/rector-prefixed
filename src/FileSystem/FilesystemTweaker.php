<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Core\FileSystem;

use _PhpScoper0a2ac50786fa\Nette\Utils\Strings;
use _PhpScoper0a2ac50786fa\Rector\Core\Exception\FileSystem\DirectoryNotFoundException;
final class FilesystemTweaker
{
    /**
     * This will turn paths like "src/Symfony/Component/*\/Tests" to existing directory paths
     *
     * @param string[] $directories
     * @return string[]
     */
    public function resolveDirectoriesWithFnmatch(array $directories) : array
    {
        $absoluteDirectories = [];
        foreach ($directories as $directory) {
            // is fnmatch for directories
            if (\_PhpScoper0a2ac50786fa\Nette\Utils\Strings::contains($directory, '*')) {
                $foundDirectories = $this->foundDirectoriesInGlob($directory);
                $absoluteDirectories = \array_merge($absoluteDirectories, $foundDirectories);
            } else {
                // is classic directory
                $this->ensureDirectoryExists($directory);
                $absoluteDirectories[] = $directory;
            }
        }
        return $absoluteDirectories;
    }
    /**
     * @return string[]
     */
    private function foundDirectoriesInGlob(string $directory) : array
    {
        $foundDirectories = [];
        foreach ((array) \glob($directory, \GLOB_ONLYDIR) as $foundDirectory) {
            if (!\is_string($foundDirectory)) {
                continue;
            }
            $foundDirectories[] = $foundDirectory;
        }
        return $foundDirectories;
    }
    private function ensureDirectoryExists(string $directory) : void
    {
        if (\file_exists($directory)) {
            return;
        }
        throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\FileSystem\DirectoryNotFoundException(\sprintf('Directory "%s" was not found.', $directory));
    }
}
