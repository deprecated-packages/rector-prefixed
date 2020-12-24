<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector;
use _PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer;
use _PhpScoper0a6b37af0871\Rector\Symfony2\Rector\StaticCall\ParseFileRector;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a6b37af0871\Rector\Symfony2\Rector\StaticCall\ParseFileRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector::REPLACED_ARGUMENTS => \_PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // https://github.com/symfony/symfony/commit/912fc4de8fd6de1e5397be4a94d39091423e5188
        new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoper0a6b37af0871\\Symfony\\Component\\Routing\\Generator\\UrlGeneratorInterface', 'generate', 2, \true, 'Symfony\\Component\\Routing\\Generator\\UrlGeneratorInterface::ABSOLUTE_URL'),
        new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoper0a6b37af0871\\Symfony\\Component\\Routing\\Generator\\UrlGeneratorInterface', 'generate', 2, \false, 'Symfony\\Component\\Routing\\Generator\\UrlGeneratorInterface::ABSOLUTE_PATH'),
        new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoper0a6b37af0871\\Symfony\\Component\\Routing\\Generator\\UrlGeneratorInterface', 'generate', 2, 'relative', 'Symfony\\Component\\Routing\\Generator\\UrlGeneratorInterface::RELATIVE_PATH'),
        new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoper0a6b37af0871\\Symfony\\Component\\Routing\\Generator\\UrlGeneratorInterface', 'generate', 2, 'network', 'Symfony\\Component\\Routing\\Generator\\UrlGeneratorInterface::NETWORK_PATH'),
    ])]]);
};
