<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\SetConfigResolver;

use _PhpScoper0a6b37af0871\Symfony\Component\Console\Input\InputInterface;
use _PhpScoper0a6b37af0871\Symplify\SetConfigResolver\Config\SetsParameterResolver;
use _PhpScoper0a6b37af0871\Symplify\SetConfigResolver\Contract\SetProviderInterface;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Symplify\SetConfigResolver\Tests\ConfigResolver\SetAwareConfigResolverTest
 */
final class SetAwareConfigResolver extends \_PhpScoper0a6b37af0871\Symplify\SetConfigResolver\AbstractConfigResolver
{
    /**
     * @var SetsParameterResolver
     */
    private $setsParameterResolver;
    /**
     * @var SetResolver
     */
    private $setResolver;
    public function __construct(\_PhpScoper0a6b37af0871\Symplify\SetConfigResolver\Contract\SetProviderInterface $setProvider)
    {
        $this->setResolver = new \_PhpScoper0a6b37af0871\Symplify\SetConfigResolver\SetResolver($setProvider);
        $this->setsParameterResolver = new \_PhpScoper0a6b37af0871\Symplify\SetConfigResolver\Config\SetsParameterResolver($this->setResolver);
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
    public function resolveSetFromInput(\_PhpScoper0a6b37af0871\Symfony\Component\Console\Input\InputInterface $input) : ?\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo
    {
        return $this->setResolver->detectFromInput($input);
    }
}
