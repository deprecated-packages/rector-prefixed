<?php

declare (strict_types=1);
namespace Rector\Utils\ProjectValidator\HttpKernel;

use _PhpScoper88fe6e0ad041\Symfony\Component\Config\Loader\LoaderInterface;
use Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class SingleConfigKernel extends \Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    /**
     * @var string
     */
    private $configFile;
    public function __construct(string $configFile)
    {
        $this->configFile = $configFile;
        parent::__construct('dev', \true);
    }
    public function registerContainerConfiguration(\_PhpScoper88fe6e0ad041\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../../../config/config.php');
        $loader->load($this->configFile);
    }
}
