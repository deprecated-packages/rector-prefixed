<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\Class_\TestListenerToHooksRector;
use _PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\MethodCall\ExplicitPhpErrorApiRector;
use _PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\MethodCall\SpecificAssertContainsWithoutIdentityRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\Class_\TestListenerToHooksRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\MethodCall\ExplicitPhpErrorApiRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\MethodCall\SpecificAssertContainsWithoutIdentityRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[
        // see https://github.com/sebastianbergmann/phpunit/issues/3957
        \_PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\TestCase', 'expectExceptionMessageRegExp', 'expectExceptionMessageMatches'), new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\TestCase', 'assertRegExp', 'assertMatchesRegularExpression')]),
    ]]);
};
