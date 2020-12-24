<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer;
use _PhpScoper2a4e7ab1ecbc\Rector\Symfony2\Rector\StaticCall\ParseFileRector;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Symfony2\Rector\StaticCall\ParseFileRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector::REPLACED_ARGUMENTS => \_PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // https://github.com/symfony/symfony/commit/912fc4de8fd6de1e5397be4a94d39091423e5188
        new \_PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Routing\\Generator\\UrlGeneratorInterface', 'generate', 2, \true, 'Symfony\\Component\\Routing\\Generator\\UrlGeneratorInterface::ABSOLUTE_URL'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Routing\\Generator\\UrlGeneratorInterface', 'generate', 2, \false, 'Symfony\\Component\\Routing\\Generator\\UrlGeneratorInterface::ABSOLUTE_PATH'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Routing\\Generator\\UrlGeneratorInterface', 'generate', 2, 'relative', 'Symfony\\Component\\Routing\\Generator\\UrlGeneratorInterface::RELATIVE_PATH'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Routing\\Generator\\UrlGeneratorInterface', 'generate', 2, 'network', 'Symfony\\Component\\Routing\\Generator\\UrlGeneratorInterface::NETWORK_PATH'),
    ])]]);
};
