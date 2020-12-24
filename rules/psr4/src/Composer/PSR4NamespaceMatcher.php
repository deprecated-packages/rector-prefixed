<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PSR4\Composer;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\FileSystem\CurrentFileInfoProvider;
use _PhpScoperb75b35f52b74\Rector\PSR4\Contract\PSR4AutoloadNamespaceMatcherInterface;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class PSR4NamespaceMatcher implements \_PhpScoperb75b35f52b74\Rector\PSR4\Contract\PSR4AutoloadNamespaceMatcherInterface
{
    /**
     * @var PSR4AutoloadPathsProvider
     */
    private $psr4AutoloadPathsProvider;
    /**
     * @var CurrentFileInfoProvider
     */
    private $currentFileInfoProvider;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\PSR4\Composer\PSR4AutoloadPathsProvider $psr4AutoloadPathsProvider, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\FileSystem\CurrentFileInfoProvider $currentFileInfoProvider)
    {
        $this->psr4AutoloadPathsProvider = $psr4AutoloadPathsProvider;
        $this->currentFileInfoProvider = $currentFileInfoProvider;
    }
    public function getExpectedNamespace(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?string
    {
        $smartFileInfo = $this->currentFileInfoProvider->getSmartFileInfo();
        if ($smartFileInfo === null) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        $psr4Autoloads = $this->psr4AutoloadPathsProvider->provide();
        foreach ($psr4Autoloads as $namespace => $path) {
            // remove extra slash
            /** @var string[] $paths */
            $paths = \is_array($path) ? $path : [$path];
            foreach ($paths as $singlePath) {
                $singlePath = \rtrim($singlePath, '/');
                if (!\_PhpScoperb75b35f52b74\Nette\Utils\Strings::startsWith($smartFileInfo->getRelativeDirectoryPath(), $singlePath)) {
                    continue;
                }
                $expectedNamespace = $namespace . $this->resolveExtraNamespace($smartFileInfo, $singlePath);
                return \rtrim($expectedNamespace, '\\');
            }
        }
        return null;
    }
    /**
     * Get the extra path that is not included in root PSR-4 namespace
     */
    private function resolveExtraNamespace(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, string $path) : string
    {
        $extraNamespace = \_PhpScoperb75b35f52b74\Nette\Utils\Strings::substring($smartFileInfo->getRelativeDirectoryPath(), \_PhpScoperb75b35f52b74\Nette\Utils\Strings::length($path) + 1);
        $extraNamespace = \_PhpScoperb75b35f52b74\Nette\Utils\Strings::replace($extraNamespace, '#/#', '\\');
        return \trim($extraNamespace);
    }
}
