<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer;
use _PhpScoperb75b35f52b74\Rector\Symfony2\Rector\StaticCall\ParseFileRector;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\Symfony2\Rector\StaticCall\ParseFileRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector::REPLACED_ARGUMENTS => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // https://github.com/symfony/symfony/commit/912fc4de8fd6de1e5397be4a94d39091423e5188
        new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoperb75b35f52b74\\Symfony\\Component\\Routing\\Generator\\UrlGeneratorInterface', 'generate', 2, \true, 'Symfony\\Component\\Routing\\Generator\\UrlGeneratorInterface::ABSOLUTE_URL'),
        new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoperb75b35f52b74\\Symfony\\Component\\Routing\\Generator\\UrlGeneratorInterface', 'generate', 2, \false, 'Symfony\\Component\\Routing\\Generator\\UrlGeneratorInterface::ABSOLUTE_PATH'),
        new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoperb75b35f52b74\\Symfony\\Component\\Routing\\Generator\\UrlGeneratorInterface', 'generate', 2, 'relative', 'Symfony\\Component\\Routing\\Generator\\UrlGeneratorInterface::RELATIVE_PATH'),
        new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoperb75b35f52b74\\Symfony\\Component\\Routing\\Generator\\UrlGeneratorInterface', 'generate', 2, 'network', 'Symfony\\Component\\Routing\\Generator\\UrlGeneratorInterface::NETWORK_PATH'),
    ])]]);
};
