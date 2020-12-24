<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Php;

use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Nette\Utils\Json;
use _PhpScopere8e811afab72\PHPStan\File\FileReader;
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
    public function create() : \_PhpScopere8e811afab72\PHPStan\Php\PhpVersionFactory
    {
        $composerPhpVersion = null;
        if ($this->readComposerPhpVersion && \count($this->composerAutoloaderProjectPaths) > 0) {
            $composerJsonPath = \end($this->composerAutoloaderProjectPaths) . '/composer.json';
            if (\is_file($composerJsonPath)) {
                try {
                    $composerJsonContents = \_PhpScopere8e811afab72\PHPStan\File\FileReader::read($composerJsonPath);
                    $composer = \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Nette\Utils\Json::decode($composerJsonContents, \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Nette\Utils\Json::FORCE_ARRAY);
                    $platformVersion = $composer['config']['platform']['php'] ?? null;
                    if (\is_string($platformVersion)) {
                        $composerPhpVersion = $platformVersion;
                    }
                } catch (\_PhpScopere8e811afab72\PHPStan\File\CouldNotReadFileException|\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Nette\Utils\JsonException $e) {
                    // pass
                }
            }
        }
        return new \_PhpScopere8e811afab72\PHPStan\Php\PhpVersionFactory($this->versionId, $composerPhpVersion);
    }
}
