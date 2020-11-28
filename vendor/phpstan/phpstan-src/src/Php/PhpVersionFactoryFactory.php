<?php

declare (strict_types=1);
namespace PHPStan\Php;

use _PhpScoperabd03f0baf05\Nette\Utils\Json;
use PHPStan\File\FileReader;
class PhpVersionFactoryFactory
{
    /**
     * @var int|null
     */
    private $versionId;
    /**
     * @var bool
     */
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
    public function create() : \PHPStan\Php\PhpVersionFactory
    {
        $composerPhpVersion = null;
        if ($this->readComposerPhpVersion && \count($this->composerAutoloaderProjectPaths) > 0) {
            $composerJsonPath = \end($this->composerAutoloaderProjectPaths) . '/composer.json';
            if (\is_file($composerJsonPath)) {
                try {
                    $composerJsonContents = \PHPStan\File\FileReader::read($composerJsonPath);
                    $composer = \_PhpScoperabd03f0baf05\Nette\Utils\Json::decode($composerJsonContents, \_PhpScoperabd03f0baf05\Nette\Utils\Json::FORCE_ARRAY);
                    $platformVersion = $composer['config']['platform']['php'] ?? null;
                    if (\is_string($platformVersion)) {
                        $composerPhpVersion = $platformVersion;
                    }
                } catch (\PHPStan\File\CouldNotReadFileException|\_PhpScoperabd03f0baf05\Nette\Utils\JsonException $e) {
                    // pass
                }
            }
        }
        return new \PHPStan\Php\PhpVersionFactory($this->versionId, $composerPhpVersion);
    }
}
