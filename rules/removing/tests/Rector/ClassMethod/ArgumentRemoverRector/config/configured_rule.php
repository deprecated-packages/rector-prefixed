<?php

namespace RectorPrefix20210302;

use Rector\Removing\Rector\ClassMethod\ArgumentRemoverRector;
use Rector\Removing\Tests\Rector\ClassMethod\ArgumentRemoverRector\Source\Persister;
use Rector\Removing\Tests\Rector\ClassMethod\ArgumentRemoverRector\Source\RemoveInTheMiddle;
use Rector\Removing\ValueObject\ArgumentRemover;
use RectorPrefix20210302\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use RectorPrefix20210302\Symfony\Component\Yaml\Yaml;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210302\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Removing\Rector\ClassMethod\ArgumentRemoverRector::class)->call('configure', [[\Rector\Removing\Rector\ClassMethod\ArgumentRemoverRector::REMOVED_ARGUMENTS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Removing\ValueObject\ArgumentRemover(\Rector\Removing\Tests\Rector\ClassMethod\ArgumentRemoverRector\Source\Persister::class, 'getSelectJoinColumnSQL', 4, null), new \Rector\Removing\ValueObject\ArgumentRemover(\RectorPrefix20210302\Symfony\Component\Yaml\Yaml::class, 'parse', 1, ['Symfony\\Component\\Yaml\\Yaml::PARSE_KEYS_AS_STRINGS', 'hey', 55, 5.5]), new \Rector\Removing\ValueObject\ArgumentRemover(\Rector\Removing\Tests\Rector\ClassMethod\ArgumentRemoverRector\Source\RemoveInTheMiddle::class, 'run', 1, ['name' => 'second'])])]]);
};
