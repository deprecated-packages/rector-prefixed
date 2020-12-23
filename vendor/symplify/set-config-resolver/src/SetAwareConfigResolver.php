<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\SetConfigResolver;

use _PhpScoper0a2ac50786fa\Symfony\Component\Console\Input\InputInterface;
use _PhpScoper0a2ac50786fa\Symplify\SetConfigResolver\Config\SetsParameterResolver;
use _PhpScoper0a2ac50786fa\Symplify\SetConfigResolver\Contract\SetProviderInterface;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Symplify\SetConfigResolver\Tests\ConfigResolver\SetAwareConfigResolverTest
 */
final class SetAwareConfigResolver extends \_PhpScoper0a2ac50786fa\Symplify\SetConfigResolver\AbstractConfigResolver
{
    /**
     * @var SetsParameterResolver
     */
    private $setsParameterResolver;
    /**
     * @var SetResolver
     */
    private $setResolver;
    public function __construct(\_PhpScoper0a2ac50786fa\Symplify\SetConfigResolver\Contract\SetProviderInterface $setProvider)
    {
        $this->setResolver = new \_PhpScoper0a2ac50786fa\Symplify\SetConfigResolver\SetResolver($setProvider);
        $this->setsParameterResolver = new \_PhpScoper0a2ac50786fa\Symplify\SetConfigResolver\Config\SetsParameterResolver($this->setResolver);
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
    public function resolveSetFromInput(\_PhpScoper0a2ac50786fa\Symfony\Component\Console\Input\InputInterface $input) : ?\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo
    {
        return $this->setResolver->detectFromInput($input);
    }
}
