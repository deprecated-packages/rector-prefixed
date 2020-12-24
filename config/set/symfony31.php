<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector;
use _PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector::REPLACED_ARGUMENTS => \_PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoper0a6b37af0871\\Symfony\\Component\\Yaml\\Yaml', 'parse', 1, [\false, \false, \true], 'Symfony\\Component\\Yaml\\Yaml::PARSE_OBJECT_FOR_MAP'), new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoper0a6b37af0871\\Symfony\\Component\\Yaml\\Yaml', 'parse', 1, [\false, \true], 'Symfony\\Component\\Yaml\\Yaml::PARSE_OBJECT'), new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoper0a6b37af0871\\Symfony\\Component\\Yaml\\Yaml', 'parse', 1, \true, 'Symfony\\Component\\Yaml\\Yaml::PARSE_EXCEPTION_ON_INVALID_TYPE'), new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoper0a6b37af0871\\Symfony\\Component\\Yaml\\Yaml', 'parse', 1, \false, 0), new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoper0a6b37af0871\\Symfony\\Component\\Yaml\\Yaml', 'dump', 3, [\false, \true], 'Symfony\\Component\\Yaml\\Yaml::DUMP_OBJECT'), new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoper0a6b37af0871\\Symfony\\Component\\Yaml\\Yaml', 'dump', 3, \true, 'Symfony\\Component\\Yaml\\Yaml::DUMP_EXCEPTION_ON_INVALID_TYPE')])]]);
};
