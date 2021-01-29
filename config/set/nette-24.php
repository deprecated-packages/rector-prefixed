<?php

declare (strict_types=1);
namespace RectorPrefix20210129;

use Rector\Generic\Rector\Class_\ParentClassToTraitsRector;
use Rector\Generic\ValueObject\ParentClassToTraits;
use RectorPrefix20210129\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
// @see https://doc.nette.org/en/2.4/migration-2-4#toc-nette-smartobject
return static function (\RectorPrefix20210129\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\Class_\ParentClassToTraitsRector::class)->call('configure', [[\Rector\Generic\Rector\Class_\ParentClassToTraitsRector::PARENT_CLASS_TO_TRAITS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Generic\ValueObject\ParentClassToTraits('Nette\\Object', ['Nette\\SmartObject'])])]]);
};
