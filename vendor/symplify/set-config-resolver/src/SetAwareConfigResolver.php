<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\SetConfigResolver;

use _PhpScopere8e811afab72\Symfony\Component\Console\Input\InputInterface;
use _PhpScopere8e811afab72\Symplify\SetConfigResolver\Config\SetsParameterResolver;
use _PhpScopere8e811afab72\Symplify\SetConfigResolver\Contract\SetProviderInterface;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Symplify\SetConfigResolver\Tests\ConfigResolver\SetAwareConfigResolverTest
 */
final class SetAwareConfigResolver extends \_PhpScopere8e811afab72\Symplify\SetConfigResolver\AbstractConfigResolver
{
    /**
     * @var SetsParameterResolver
     */
    private $setsParameterResolver;
    /**
     * @var SetResolver
     */
    private $setResolver;
    public function __construct(\_PhpScopere8e811afab72\Symplify\SetConfigResolver\Contract\SetProviderInterface $setProvider)
    {
        $this->setResolver = new \_PhpScopere8e811afab72\Symplify\SetConfigResolver\SetResolver($setProvider);
        $this->setsParameterResolver = new \_PhpScopere8e811afab72\Symplify\SetConfigResolver\Config\SetsParameterResolver($this->setResolver);
        parent::__construct();
    }
    /**
     * @param SmartFileInfo[] $fileInfos
     * @return SmartFileInfo[]
     */
    public function resolveFromParameterSetsFromConfigFiles(array $fileInfos) : array
    {
        return $this->setsParameterResolver->resolveFromFileInfos($fileInfos);
    }
    public function resolveSetFromInput(\_PhpScopere8e811afab72\Symfony\Component\Console\Input\InputInterface $input) : ?\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo
    {
        return $this->setResolver->detectFromInput($input);
    }
}
