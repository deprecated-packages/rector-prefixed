<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa;

use _PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\Class_\TestListenerToHooksRector;
use _PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\MethodCall\ExplicitPhpErrorApiRector;
use _PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\MethodCall\SpecificAssertContainsWithoutIdentityRector;
use _PhpScoper0a2ac50786fa\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a2ac50786fa\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\Class_\TestListenerToHooksRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\MethodCall\ExplicitPhpErrorApiRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\MethodCall\SpecificAssertContainsWithoutIdentityRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[
        // see https://github.com/sebastianbergmann/phpunit/issues/3957
        \_PhpScoper0a2ac50786fa\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoper0a2ac50786fa\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\PHPUnit\\Framework\\TestCase', 'expectExceptionMessageRegExp', 'expectExceptionMessageMatches'), new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\PHPUnit\\Framework\\TestCase', 'assertRegExp', 'assertMatchesRegularExpression')]),
    ]]);
};
