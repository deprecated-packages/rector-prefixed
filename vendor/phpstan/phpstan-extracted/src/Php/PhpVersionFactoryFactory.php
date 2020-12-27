<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Php;

use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Nette\Utils\Json;
use RectorPrefix20201227\PHPStan\File\FileReader;
class PhpVersionFactoryFactory
{
    /** @var int|null */
    private $versionId;
    /** @var bool */
    private $readComposerPhpVersion;
    /** @var string[] */
    private $composerAutoloaderProjectPaths;
    /**
     * @param bool $readComposerPhpVersion
     * @param string[] $composerAutoloaderProjectPaths
     */
    public function __construct(?int $versionId, bool $readComposerPhpVersion, array $composerAutoloaderProjectPaths)
    {
        $this->versionId = $versionId;
        $this->readComposerPhpVersion = $readComposerPhpVersion;
        $this->composerAutoloaderProjectPaths = $composerAutoloaderProjectPaths;
    }
    public function create() : \RectorPrefix20201227\PHPStan\Php\PhpVersionFactory
    {
        $composerPhpVersion = null;
        if ($this->readComposerPhpVersion && \count($this->composerAutoloaderProjectPaths) > 0) {
            $composerJsonPath = \end($this->composerAutoloaderProjectPaths) . '/composer.json';
            if (\is_file($composerJsonPath)) {
                try {
                    $composerJsonContents = \RectorPrefix20201227\PHPStan\File\FileReader::read($composerJsonPath);
                    $composer = \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Nette\Utils\Json::decode($composerJsonContents, \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Nette\Utils\Json::FORCE_ARRAY);
                    $platformVersion = $composer['config']['platform']['php'] ?? null;
                    if (\is_string($platformVersion)) {
                        $composerPhpVersion = $platformVersion;
                    }
                } catch (\RectorPrefix20201227\PHPStan\File\CouldNotReadFileException|\RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Nette\Utils\JsonException $e) {
                    // pass
                }
            }
        }
        return new \RectorPrefix20201227\PHPStan\Php\PhpVersionFactory($this->versionId, $composerPhpVersion);
    }
}
