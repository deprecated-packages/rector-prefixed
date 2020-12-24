<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\Class_\RemoveDataProviderTestPrefixRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\ClassMethod\RenameAnnotationRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameAnnotation;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/phpunit-exception.php');
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\ClassMethod\RenameAnnotationRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\ClassMethod\RenameAnnotationRector::RENAMED_ANNOTATIONS_IN_TYPES => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameAnnotation('_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\TestCase', 'scenario', 'test')])]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\Class_\RemoveDataProviderTestPrefixRector::class);
};
