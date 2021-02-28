<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\Reflection\BetterReflection\SourceLocatorProvider;

use PHPStan\BetterReflection\SourceLocator\Type\AggregateSourceLocator;
use PHPStan\BetterReflection\SourceLocator\Type\SourceLocator;
use PHPStan\Reflection\BetterReflection\SourceLocator\FileNodesFetcher;
use PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedSingleFileSourceLocator;
use Rector\NodeTypeResolver\Contract\SourceLocatorProviderInterface;
use RectorPrefix20210228\Symplify\SmartFileSystem\SmartFileInfo;
final class DynamicSourceLocatorProvider implements \Rector\NodeTypeResolver\Contract\SourceLocatorProviderInterface
{
    /**
     * @var SmartFileInfo[]
     */
    private $fileInfos = [];
    /**
     * @var FileNodesFetcher
     */
    private $fileNodesFetcher;
    public function __construct(\PHPStan\Reflection\BetterReflection\SourceLocator\FileNodesFetcher $fileNodesFetcher)
    {
        $this->fileNodesFetcher = $fileNodesFetcher;
    }
    public function setFileInfo(\RectorPrefix20210228\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->fileInfos = [$fileInfo];
    }
    /**
     * @param SmartFileInfo[] $fileInfos
     */
    public function addFileInfos(array $fileInfos) : void
    {
        $this->fileInfos = \array_merge($this->fileInfos, $fileInfos);
    }
    public function provide() : \PHPStan\BetterReflection\SourceLocator\Type\SourceLocator
    {
        $sourceLocators = [];
        foreach ($this->fileInfos as $fileInfo) {
            $sourceLocators[] = new \PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedSingleFileSourceLocator($this->fileNodesFetcher, $fileInfo->getRealPath());
        }
        return new \PHPStan\BetterReflection\SourceLocator\Type\AggregateSourceLocator($sourceLocators);
    }
}
