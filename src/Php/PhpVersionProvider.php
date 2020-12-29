<?php

declare (strict_types=1);
namespace Rector\Core\Php;

use RectorPrefix20201229\Nette\Utils\Json;
use Rector\Core\Configuration\Option;
use Rector\Core\Util\PhpVersionFactory;
use Rector\Testing\PHPUnit\StaticPHPUnitEnvironment;
use RectorPrefix20201229\Symplify\PackageBuilder\Parameter\ParameterProvider;
use RectorPrefix20201229\Symplify\SmartFileSystem\SmartFileSystem;
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
    public function __construct(\RectorPrefix20201229\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider, \RectorPrefix20201229\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \Rector\Core\Util\PhpVersionFactory $phpVersionFactory)
    {
        $this->parameterProvider = $parameterProvider;
        $this->smartFileSystem = $smartFileSystem;
        $this->phpVersionFactory = $phpVersionFactory;
    }
    public function provide() : int
    {
        /** @var int|null $phpVersionFeatures */
        $phpVersionFeatures = $this->parameterProvider->provideParameter(\Rector\Core\Configuration\Option::PHP_VERSION_FEATURES);
        if ($phpVersionFeatures !== null) {
            return $phpVersionFeatures;
        }
        // for tests
        if (\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun()) {
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
        $projectComposerJson = \RectorPrefix20201229\Nette\Utils\Json::decode($projectComposerContent, \RectorPrefix20201229\Nette\Utils\Json::FORCE_ARRAY);
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
