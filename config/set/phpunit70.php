<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Rector\PHPUnit\Rector\Class_\RemoveDataProviderTestPrefixRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\ClassMethod\RenameAnnotationRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\RenameAnnotation;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/phpunit-exception.php');
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\ClassMethod\RenameAnnotationRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\ClassMethod\RenameAnnotationRector::RENAMED_ANNOTATIONS_IN_TYPES => \_PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\RenameAnnotation('_PhpScoper2a4e7ab1ecbc\\PHPUnit\\Framework\\TestCase', 'scenario', 'test')])]]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\PHPUnit\Rector\Class_\RemoveDataProviderTestPrefixRector::class);
};
