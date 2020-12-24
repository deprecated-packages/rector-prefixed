<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\PHPUnit\Rector\Class_\RemoveDataProviderTestPrefixRector;
use _PhpScoper0a6b37af0871\Rector\Renaming\Rector\ClassMethod\RenameAnnotationRector;
use _PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\RenameAnnotation;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/phpunit-exception.php');
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\ClassMethod\RenameAnnotationRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\ClassMethod\RenameAnnotationRector::RENAMED_ANNOTATIONS_IN_TYPES => \_PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\RenameAnnotation('_PhpScoper0a6b37af0871\\PHPUnit\\Framework\\TestCase', 'scenario', 'test')])]]);
    $services->set(\_PhpScoper0a6b37af0871\Rector\PHPUnit\Rector\Class_\RemoveDataProviderTestPrefixRector::class);
};
