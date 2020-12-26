<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat;

use Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector;
use Rector\Generic\ValueObject\ArgumentDefaultValueReplacer;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector::REPLACED_ARGUMENTS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('RectorPrefix2020DecSat\\Symfony\\Component\\Yaml\\Yaml', 'parse', 1, [\false, \false, \true], 'Symfony\\Component\\Yaml\\Yaml::PARSE_OBJECT_FOR_MAP'), new \Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('RectorPrefix2020DecSat\\Symfony\\Component\\Yaml\\Yaml', 'parse', 1, [\false, \true], 'Symfony\\Component\\Yaml\\Yaml::PARSE_OBJECT'), new \Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('RectorPrefix2020DecSat\\Symfony\\Component\\Yaml\\Yaml', 'parse', 1, \true, 'Symfony\\Component\\Yaml\\Yaml::PARSE_EXCEPTION_ON_INVALID_TYPE'), new \Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('RectorPrefix2020DecSat\\Symfony\\Component\\Yaml\\Yaml', 'parse', 1, \false, 0), new \Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('RectorPrefix2020DecSat\\Symfony\\Component\\Yaml\\Yaml', 'dump', 3, [\false, \true], 'Symfony\\Component\\Yaml\\Yaml::DUMP_OBJECT'), new \Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('RectorPrefix2020DecSat\\Symfony\\Component\\Yaml\\Yaml', 'dump', 3, \true, 'Symfony\\Component\\Yaml\\Yaml::DUMP_EXCEPTION_ON_INVALID_TYPE')])]]);
};
