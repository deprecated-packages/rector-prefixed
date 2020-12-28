<?php

declare (strict_types=1);
namespace RectorPrefix20201228\Symplify\SetConfigResolver;

use RectorPrefix20201228\Symfony\Component\Console\Input\InputInterface;
use RectorPrefix20201228\Symplify\SetConfigResolver\Config\SetsParameterResolver;
use RectorPrefix20201228\Symplify\SetConfigResolver\Contract\SetProviderInterface;
use RectorPrefix20201228\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Symplify\SetConfigResolver\Tests\ConfigResolver\SetAwareConfigResolverTest
 */
final class SetAwareConfigResolver extends \RectorPrefix20201228\Symplify\SetConfigResolver\AbstractConfigResolver
{
    /**
     * @var SetsParameterResolver
     */
    private $setsParameterResolver;
    /**
     * @var SetResolver
     */
    private $setResolver;
    public function __construct(\RectorPrefix20201228\Symplify\SetConfigResolver\Contract\SetProviderInterface $setProvider)
    {
        $this->setResolver = new \RectorPrefix20201228\Symplify\SetConfigResolver\SetResolver($setProvider);
        $this->setsParameterResolver = new \RectorPrefix20201228\Symplify\SetConfigResolver\Config\SetsParameterResolver($this->setResolver);
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
    public function resolveSetFromInput(\RectorPrefix20201228\Symfony\Component\Console\Input\InputInterface $input) : ?\RectorPrefix20201228\Symplify\SmartFileSystem\SmartFileInfo
    {
        return $this->setResolver->detectFromInput($input);
    }
}
