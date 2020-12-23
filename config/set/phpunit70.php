<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa;

use _PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\Class_\RemoveDataProviderTestPrefixRector;
use _PhpScoper0a2ac50786fa\Rector\Renaming\Rector\ClassMethod\RenameAnnotationRector;
use _PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\RenameAnnotation;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a2ac50786fa\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/phpunit-exception.php');
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Renaming\Rector\ClassMethod\RenameAnnotationRector::class)->call('configure', [[\_PhpScoper0a2ac50786fa\Rector\Renaming\Rector\ClassMethod\RenameAnnotationRector::RENAMED_ANNOTATIONS_IN_TYPES => \_PhpScoper0a2ac50786fa\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\RenameAnnotation('_PhpScoper0a2ac50786fa\\PHPUnit\\Framework\\TestCase', 'scenario', 'test')])]]);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\Class_\RemoveDataProviderTestPrefixRector::class);
};
