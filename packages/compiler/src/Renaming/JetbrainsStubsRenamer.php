<?php

declare (strict_types=1);
namespace Rector\Compiler\Renaming;

use _PhpScoperbd5d0c5f7638\Nette\Utils\Strings;
use Rector\Core\Exception\ShouldNotHappenException;
use Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScoperbd5d0c5f7638\Symfony\Component\Finder\Finder;
use _PhpScoperbd5d0c5f7638\Symfony\Component\Finder\SplFileInfo;
use Symplify\SmartFileSystem\SmartFileSystem;
final class JetbrainsStubsRenamer
{
    /**
     * @var string
     * @see https://regex101.com/r/K7XJBF/1
     */
    private const PHP_SUFFIX_COMMA_REGEX = '#\\.php\',#m';
    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    public function __construct(\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem)
    {
        $this->symfonyStyle = $symfonyStyle;
        $this->smartFileSystem = $smartFileSystem;
    }
    public function renamePhpStormStubs(string $directory) : void
    {
        $this->renameStubFileSuffixes($directory);
        $this->renameFilesSuffixesInPhpStormStubsMapFile($directory);
    }
    private function renameStubFileSuffixes(string $directory) : void
    {
        $stubFileInfos = $this->getStubFileInfos($directory);
        $message = \sprintf('Renaming "%d" stub files from "%s"', \count($stubFileInfos), 'vendor/jetbrains/phpstorm-stubs');
        $this->symfonyStyle->note($message);
        foreach ($stubFileInfos as $stubFileInfo) {
            $path = $stubFileInfo->getPathname();
            $filenameWithStubSuffix = \dirname($path) . '/' . $stubFileInfo->getBasename('.php') . '.stub';
            $this->smartFileSystem->rename($path, $filenameWithStubSuffix);
        }
    }
    private function renameFilesSuffixesInPhpStormStubsMapFile(string $phpStormStubsDirectory) : void
    {
        $stubsMapPath = $phpStormStubsDirectory . '/PhpStormStubsMap.php';
        if (!\file_exists($stubsMapPath)) {
            throw new \Rector\Core\Exception\ShouldNotHappenException(\sprintf('File "%s" was not found', $stubsMapPath));
        }
        $stubsMapContents = $this->smartFileSystem->readFile($stubsMapPath);
        $stubsMapContents = \_PhpScoperbd5d0c5f7638\Nette\Utils\Strings::replace($stubsMapContents, self::PHP_SUFFIX_COMMA_REGEX, ".stub',");
        $this->smartFileSystem->dumpFile($stubsMapPath, $stubsMapContents);
    }
    /**
     * @return SplFileInfo[]
     */
    private function getStubFileInfos(string $phpStormStubsDirectory) : array
    {
        if (!\is_dir($phpStormStubsDirectory)) {
            throw new \Rector\Core\Exception\ShouldNotHappenException(\sprintf('Directory "%s" was not found', $phpStormStubsDirectory));
        }
        $stubFinder = \_PhpScoperbd5d0c5f7638\Symfony\Component\Finder\Finder::create()->files()->name('*.php')->in($phpStormStubsDirectory)->notName('#PhpStormStubsMap\\.php$#');
        return \iterator_to_array($stubFinder->getIterator());
    }
}
