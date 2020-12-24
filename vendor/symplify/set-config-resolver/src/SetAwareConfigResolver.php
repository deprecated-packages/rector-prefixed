<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\SetConfigResolver;

use _PhpScoperb75b35f52b74\Symfony\Component\Console\Input\InputInterface;
use _PhpScoperb75b35f52b74\Symplify\SetConfigResolver\Config\SetsParameterResolver;
use _PhpScoperb75b35f52b74\Symplify\SetConfigResolver\Contract\SetProviderInterface;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Symplify\SetConfigResolver\Tests\ConfigResolver\SetAwareConfigResolverTest
 */
final class SetAwareConfigResolver extends \_PhpScoperb75b35f52b74\Symplify\SetConfigResolver\AbstractConfigResolver
{
    /**
     * @var SetsParameterResolver
     */
    private $setsParameterResolver;
    /**
     * @var SetResolver
     */
    private $setResolver;
    public function __construct(\_PhpScoperb75b35f52b74\Symplify\SetConfigResolver\Contract\SetProviderInterface $setProvider)
    {
        $this->setResolver = new \_PhpScoperb75b35f52b74\Symplify\SetConfigResolver\SetResolver($setProvider);
        $this->setsParameterResolver = new \_PhpScoperb75b35f52b74\Symplify\SetConfigResolver\Config\SetsParameterResolver($this->setResolver);
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
    public function resolveSetFromInput(\_PhpScoperb75b35f52b74\Symfony\Component\Console\Input\InputInterface $input) : ?\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo
    {
        return $this->setResolver->detectFromInput($input);
    }
}
