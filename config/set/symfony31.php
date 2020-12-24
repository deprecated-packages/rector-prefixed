<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector::REPLACED_ARGUMENTS => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScopere8e811afab72\\Symfony\\Component\\Yaml\\Yaml', 'parse', 1, [\false, \false, \true], 'Symfony\\Component\\Yaml\\Yaml::PARSE_OBJECT_FOR_MAP'), new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScopere8e811afab72\\Symfony\\Component\\Yaml\\Yaml', 'parse', 1, [\false, \true], 'Symfony\\Component\\Yaml\\Yaml::PARSE_OBJECT'), new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScopere8e811afab72\\Symfony\\Component\\Yaml\\Yaml', 'parse', 1, \true, 'Symfony\\Component\\Yaml\\Yaml::PARSE_EXCEPTION_ON_INVALID_TYPE'), new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScopere8e811afab72\\Symfony\\Component\\Yaml\\Yaml', 'parse', 1, \false, 0), new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScopere8e811afab72\\Symfony\\Component\\Yaml\\Yaml', 'dump', 3, [\false, \true], 'Symfony\\Component\\Yaml\\Yaml::DUMP_OBJECT'), new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScopere8e811afab72\\Symfony\\Component\\Yaml\\Yaml', 'dump', 3, \true, 'Symfony\\Component\\Yaml\\Yaml::DUMP_EXCEPTION_ON_INVALID_TYPE')])]]);
};
