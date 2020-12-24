<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Symplify\SetConfigResolver;

use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Input\InputInterface;
use _PhpScoper2a4e7ab1ecbc\Symplify\SetConfigResolver\Config\SetsParameterResolver;
use _PhpScoper2a4e7ab1ecbc\Symplify\SetConfigResolver\Contract\SetProviderInterface;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Symplify\SetConfigResolver\Tests\ConfigResolver\SetAwareConfigResolverTest
 */
final class SetAwareConfigResolver extends \_PhpScoper2a4e7ab1ecbc\Symplify\SetConfigResolver\AbstractConfigResolver
{
    /**
     * @var SetsParameterResolver
     */
    private $setsParameterResolver;
    /**
     * @var SetResolver
     */
    private $setResolver;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Symplify\SetConfigResolver\Contract\SetProviderInterface $setProvider)
    {
        $this->setResolver = new \_PhpScoper2a4e7ab1ecbc\Symplify\SetConfigResolver\SetResolver($setProvider);
        $this->setsParameterResolver = new \_PhpScoper2a4e7ab1ecbc\Symplify\SetConfigResolver\Config\SetsParameterResolver($this->setResolver);
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
    public function resolveSetFromInput(\_PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Input\InputInterface $input) : ?\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo
    {
        return $this->setResolver->detectFromInput($input);
    }
}
