<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\Php;

use _PhpScoperb75b35f52b74\Nette\Utils\Json;
use _PhpScoperb75b35f52b74\Rector\Core\Configuration\Option;
use _PhpScoperb75b35f52b74\Rector\Core\Util\PhpVersionFactory;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Parameter\ParameterProvider;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileSystem;
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
    public function __construct(\_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider, \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \_PhpScoperb75b35f52b74\Rector\Core\Util\PhpVersionFactory $phpVersionFactory)
    {
        $this->parameterProvider = $parameterProvider;
        $this->smartFileSystem = $smartFileSystem;
        $this->phpVersionFactory = $phpVersionFactory;
    }
    public function provide() : int
    {
        /** @var int|null $phpVersionFeatures */
        $phpVersionFeatures = $this->parameterProvider->provideParameter(\_PhpScoperb75b35f52b74\Rector\Core\Configuration\Option::PHP_VERSION_FEATURES);
        if ($phpVersionFeatures !== null) {
            return (int) $phpVersionFeatures;
        }
        // for tests
        if (\_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun()) {
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
        $projectComposerJson = \_PhpScoperb75b35f52b74\Nette\Utils\Json::decode($projectComposerContent, \_PhpScoperb75b35f52b74\Nette\Utils\Json::FORCE_ARRAY);
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
