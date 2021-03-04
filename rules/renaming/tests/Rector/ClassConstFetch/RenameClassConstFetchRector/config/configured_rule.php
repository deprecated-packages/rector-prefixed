<?php

namespace RectorPrefix20210304;

use Rector\Renaming\Rector\ClassConstFetch\RenameClassConstFetchRector;
use Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstFetchRector\Source\DifferentClass;
use Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstFetchRector\Source\LocalFormEvents;
use Rector\Renaming\ValueObject\RenameClassAndConstFetch;
use Rector\Renaming\ValueObject\RenameClassConstFetch;
use RectorPrefix20210304\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210304\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstFetchRector::class)->call('configure', [[\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstFetchRector::CLASS_CONSTANT_RENAME => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\RenameClassConstFetch(\Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstFetchRector\Source\LocalFormEvents::class, 'PRE_BIND', 'PRE_SUBMIT'), new \Rector\Renaming\ValueObject\RenameClassConstFetch(\Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstFetchRector\Source\LocalFormEvents::class, 'BIND', 'SUBMIT'), new \Rector\Renaming\ValueObject\RenameClassConstFetch(\Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstFetchRector\Source\LocalFormEvents::class, 'POST_BIND', 'POST_SUBMIT'), new \Rector\Renaming\ValueObject\RenameClassAndConstFetch(\Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstFetchRector\Source\LocalFormEvents::class, 'OLD_CONSTANT', \Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstFetchRector\Source\DifferentClass::class, 'NEW_CONSTANT')])]]);
};
