<?php

declare (strict_types=1);
namespace RectorPrefix20210319;

use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Transform\Rector\String_\StringToClassConstantRector;
use Rector\Transform\ValueObject\StringToClassConstant;
use RectorPrefix20210319\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
# see: https://laravel.com/docs/5.2/upgrade
return static function (\RectorPrefix20210319\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['RectorPrefix20210319\\Illuminate\\Auth\\Access\\UnauthorizedException' => 'RectorPrefix20210319\\Illuminate\\Auth\\Access\\AuthorizationException', 'RectorPrefix20210319\\Illuminate\\Http\\Exception\\HttpResponseException' => 'RectorPrefix20210319\\Illuminate\\Foundation\\Validation\\ValidationException', 'RectorPrefix20210319\\Illuminate\\Foundation\\Composer' => 'RectorPrefix20210319\\Illuminate\\Support\\Composer']]]);
    $services->set(\Rector\Transform\Rector\String_\StringToClassConstantRector::class)->call('configure', [[\Rector\Transform\Rector\String_\StringToClassConstantRector::STRINGS_TO_CLASS_CONSTANTS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Transform\ValueObject\StringToClassConstant('artisan.start', 'RectorPrefix20210319\\Illuminate\\Console\\Events\\ArtisanStarting', 'class'), new \Rector\Transform\ValueObject\StringToClassConstant('auth.attempting', 'RectorPrefix20210319\\Illuminate\\Auth\\Events\\Attempting', 'class'), new \Rector\Transform\ValueObject\StringToClassConstant('auth.login', 'RectorPrefix20210319\\Illuminate\\Auth\\Events\\Login', 'class'), new \Rector\Transform\ValueObject\StringToClassConstant('auth.logout', 'RectorPrefix20210319\\Illuminate\\Auth\\Events\\Logout', 'class'), new \Rector\Transform\ValueObject\StringToClassConstant('cache.missed', 'RectorPrefix20210319\\Illuminate\\Cache\\Events\\CacheMissed', 'class'), new \Rector\Transform\ValueObject\StringToClassConstant('cache.hit', 'RectorPrefix20210319\\Illuminate\\Cache\\Events\\CacheHit', 'class'), new \Rector\Transform\ValueObject\StringToClassConstant('cache.write', 'RectorPrefix20210319\\Illuminate\\Cache\\Events\\KeyWritten', 'class'), new \Rector\Transform\ValueObject\StringToClassConstant('cache.delete', 'RectorPrefix20210319\\Illuminate\\Cache\\Events\\KeyForgotten', 'class'), new \Rector\Transform\ValueObject\StringToClassConstant('illuminate.query', 'RectorPrefix20210319\\Illuminate\\Database\\Events\\QueryExecuted', 'class'), new \Rector\Transform\ValueObject\StringToClassConstant('illuminate.queue.before', 'RectorPrefix20210319\\Illuminate\\Queue\\Events\\JobProcessing', 'class'), new \Rector\Transform\ValueObject\StringToClassConstant('illuminate.queue.after', 'RectorPrefix20210319\\Illuminate\\Queue\\Events\\JobProcessed', 'class'), new \Rector\Transform\ValueObject\StringToClassConstant('illuminate.queue.failed', 'RectorPrefix20210319\\Illuminate\\Queue\\Events\\JobFailed', 'class'), new \Rector\Transform\ValueObject\StringToClassConstant('illuminate.queue.stopping', 'RectorPrefix20210319\\Illuminate\\Queue\\Events\\WorkerStopping', 'class'), new \Rector\Transform\ValueObject\StringToClassConstant('mailer.sending', 'RectorPrefix20210319\\Illuminate\\Mail\\Events\\MessageSending', 'class'), new \Rector\Transform\ValueObject\StringToClassConstant('router.matched', 'RectorPrefix20210319\\Illuminate\\Routing\\Events\\RouteMatched', 'class')])]]);
};