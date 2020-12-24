<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\Generic\Rector\String_\StringToClassConstantRector;
use _PhpScoper0a6b37af0871\Rector\Generic\ValueObject\StringToClassConstant;
use _PhpScoper0a6b37af0871\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner;
# see: https://laravel.com/docs/5.2/upgrade
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoper0a6b37af0871\\Illuminate\\Auth\\Access\\UnauthorizedException' => '_PhpScoper0a6b37af0871\\Illuminate\\Auth\\Access\\AuthorizationException', '_PhpScoper0a6b37af0871\\Illuminate\\Http\\Exception\\HttpResponseException' => '_PhpScoper0a6b37af0871\\Illuminate\\Foundation\\Validation\\ValidationException', '_PhpScoper0a6b37af0871\\Illuminate\\Foundation\\Composer' => '_PhpScoper0a6b37af0871\\Illuminate\\Support\\Composer']]]);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Generic\Rector\String_\StringToClassConstantRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Generic\Rector\String_\StringToClassConstantRector::STRINGS_TO_CLASS_CONSTANTS => \_PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\StringToClassConstant('artisan.start', '_PhpScoper0a6b37af0871\\Illuminate\\Console\\Events\\ArtisanStarting', 'class'), new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\StringToClassConstant('auth.attempting', '_PhpScoper0a6b37af0871\\Illuminate\\Auth\\Events\\Attempting', 'class'), new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\StringToClassConstant('auth.login', '_PhpScoper0a6b37af0871\\Illuminate\\Auth\\Events\\Login', 'class'), new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\StringToClassConstant('auth.logout', '_PhpScoper0a6b37af0871\\Illuminate\\Auth\\Events\\Logout', 'class'), new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\StringToClassConstant('cache.missed', '_PhpScoper0a6b37af0871\\Illuminate\\Cache\\Events\\CacheMissed', 'class'), new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\StringToClassConstant('cache.hit', '_PhpScoper0a6b37af0871\\Illuminate\\Cache\\Events\\CacheHit', 'class'), new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\StringToClassConstant('cache.write', '_PhpScoper0a6b37af0871\\Illuminate\\Cache\\Events\\KeyWritten', 'class'), new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\StringToClassConstant('cache.delete', '_PhpScoper0a6b37af0871\\Illuminate\\Cache\\Events\\KeyForgotten', 'class'), new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\StringToClassConstant('illuminate.query', '_PhpScoper0a6b37af0871\\Illuminate\\Database\\Events\\QueryExecuted', 'class'), new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\StringToClassConstant('illuminate.queue.before', '_PhpScoper0a6b37af0871\\Illuminate\\Queue\\Events\\JobProcessing', 'class'), new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\StringToClassConstant('illuminate.queue.after', '_PhpScoper0a6b37af0871\\Illuminate\\Queue\\Events\\JobProcessed', 'class'), new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\StringToClassConstant('illuminate.queue.failed', '_PhpScoper0a6b37af0871\\Illuminate\\Queue\\Events\\JobFailed', 'class'), new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\StringToClassConstant('illuminate.queue.stopping', '_PhpScoper0a6b37af0871\\Illuminate\\Queue\\Events\\WorkerStopping', 'class'), new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\StringToClassConstant('mailer.sending', '_PhpScoper0a6b37af0871\\Illuminate\\Mail\\Events\\MessageSending', 'class'), new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\StringToClassConstant('router.matched', '_PhpScoper0a6b37af0871\\Illuminate\\Routing\\Events\\RouteMatched', 'class')])]]);
};
