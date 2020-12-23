<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Core\Php;

use _PhpScoper0a2ac50786fa\Nette\Utils\Json;
use _PhpScoper0a2ac50786fa\Rector\Core\Configuration\Option;
use _PhpScoper0a2ac50786fa\Rector\Core\Util\PhpVersionFactory;
use _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment;
use _PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Parameter\ParameterProvider;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileSystem;
final class PhpVersionProvider
{
    /**
     * @var ParameterProvider
     */
    private $parameterProvider;
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    /**
     * @var PhpVersionFactory
     */
    private $phpVersionFactory;
    public function __construct(\_PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider, \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \_PhpScoper0a2ac50786fa\Rector\Core\Util\PhpVersionFactory $phpVersionFactory)
    {
        $this->parameterProvider = $parameterProvider;
        $this->smartFileSystem = $smartFileSystem;
        $this->phpVersionFactory = $phpVersionFactory;
    }
    public function provide() : int
    {
        /** @var int|null $phpVersionFeatures */
        $phpVersionFeatures = $this->parameterProvider->provideParameter(\_PhpScoper0a2ac50786fa\Rector\Core\Configuration\Option::PHP_VERSION_FEATURES);
        if ($phpVersionFeatures !== null) {
            return (int) $phpVersionFeatures;
        }
        // for tests
        if (\_PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun()) {
            // so we don't have to up
            return 100000;
        }
        // see https://getcomposer.org/doc/06-config.md#platform
        $platformPhp = $this->provideProjectComposerJsonConfigPlatformPhp();
        if ($platformPhp !== null) {
            return $platformPhp;
        }
        return \PHP_VERSION_ID;
    }
    public function isAtLeastPhpVersion(int $phpVersion) : bool
    {
        return $phpVersion <= $this->provide();
    }
    private function provideProjectComposerJsonConfigPlatformPhp() : ?int
    {
        $projectComposerJson = \getcwd() . '/composer.json';
        if (!\file_exists($projectComposerJson)) {
            return null;
        }
        $projectComposerContent = $this->smartFileSystem->readFile($projectComposerJson);
        $projectComposerJson = \_PhpScoper0a2ac50786fa\Nette\Utils\Json::decode($projectComposerContent, \_PhpScoper0a2ac50786fa\Nette\Utils\Json::FORCE_ARRAY);
        // Rector's composer.json
        if (isset($projectComposerJson['name']) && $projectComposerJson['name'] === 'rector/rector') {
            return null;
        }
        $platformPhp = $projectComposerJson['config']['platform']['php'] ?? null;
        if ($platformPhp !== null) {
            return $this->phpVersionFactory->createIntVersion($platformPhp);
        }
        return null;
    }
}
