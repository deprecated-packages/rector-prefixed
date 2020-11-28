<?php

// handy script for fast local operations
declare (strict_types=1);
namespace _PhpScoperabd03f0baf05;

use _PhpScoperabd03f0baf05\Nette\Utils\Strings;
use Symplify\SmartFileSystem\FileSystemFilter;
use Symplify\SmartFileSystem\Finder\FinderSanitizer;
use Symplify\SmartFileSystem\Finder\SmartFinder;
use Symplify\SmartFileSystem\SmartFileInfo;
use Symplify\SmartFileSystem\SmartFileSystem;
use _PhpScoperabd03f0baf05\Webmozart\Assert\Assert;
require __DIR__ . '/../vendor/autoload.php';
// USE ↓
$fileRenamer = new \_PhpScoperabd03f0baf05\FileRenamer();
$fileRenamer->rename(
    // paths
    [__DIR__ . '/../utils/node-documentation-generator/snippet'],
    '*.php.inc',
    '#(\\.php\\.inc)$#',
    '.php'
);
// CODE ↓
final class FileRenamer
{
    /**
     * @var SmartFinder
     */
    private $smartFinder;
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    public function __construct()
    {
        $this->smartFinder = new \Symplify\SmartFileSystem\Finder\SmartFinder(new \Symplify\SmartFileSystem\Finder\FinderSanitizer(), new \Symplify\SmartFileSystem\FileSystemFilter());
        $this->smartFileSystem = new \Symplify\SmartFileSystem\SmartFileSystem();
    }
    /**
     * @param string[] $sources
     */
    public function rename(array $sources, string $suffix, string $matchingRegex, string $replacement)
    {
        \_PhpScoperabd03f0baf05\Webmozart\Assert\Assert::allString($sources);
        \_PhpScoperabd03f0baf05\Webmozart\Assert\Assert::allFileExists($sources);
        $fileInfos = $this->smartFinder->find($sources, $suffix);
        $this->renameFileInfos($fileInfos, $matchingRegex, $replacement);
    }
    /**
     * @param SmartFileInfo[] $fileInfos
     */
    private function renameFileInfos(array $fileInfos, string $matchingRegex, string $replacement) : void
    {
        foreach ($fileInfos as $fileInfo) {
            // do the rename
            $oldRealPath = $fileInfo->getRealPath();
            $newRealPath = \_PhpScoperabd03f0baf05\Nette\Utils\Strings::replace($oldRealPath, $matchingRegex, $replacement);
            if ($oldRealPath === $newRealPath) {
                continue;
            }
            $this->smartFileSystem->rename($oldRealPath, $newRealPath);
        }
    }
}
// CODE ↓
\class_alias('_PhpScoperabd03f0baf05\\FileRenamer', 'FileRenamer', \false);
