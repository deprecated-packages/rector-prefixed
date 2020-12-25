<?php

declare (strict_types=1);
namespace _PhpScoper5edc98a7cce2;

use Rector\Generic\Rector\FuncCall\FuncCallToNewRector;
use Rector\Laravel\Rector\FuncCall\HelperFuncCallToFacadeClassRector;
use Rector\Laravel\Rector\StaticCall\RequestStaticValidateToInjectRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Transform\Rector\FuncCall\ArgumentFuncCallToMethodCallRector;
use Rector\Transform\Rector\StaticCall\StaticCallToMethodCallRector;
use Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall;
use Rector\Transform\ValueObject\ArrayFuncCallToMethodCall;
use Rector\Transform\ValueObject\StaticCallToMethodCall;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
/**
 * @see https://www.freecodecamp.org/news/moving-away-from-magic-or-why-i-dont-want-to-use-laravel-anymore-2ce098c979bd/
 * @see https://tomasvotruba.com/blog/2019/03/04/how-to-turn-laravel-from-static-to-dependency-injection-in-one-day/
 * @see https://laravel.com/docs/5.7/facades#facades-vs-dependency-injection
 */
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/laravel-array-str-functions-to-static-call.php');
    $services = $containerConfigurator->services();
    $services->set(\Rector\Transform\Rector\StaticCall\StaticCallToMethodCallRector::class)->call('configure', [[\Rector\Transform\Rector\StaticCall\StaticCallToMethodCallRector::STATIC_CALLS_TO_METHOD_CALLS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\App', '*', '_PhpScoper5edc98a7cce2\\Illuminate\\Foundation\\Application', '*'), new \Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Artisan', '*', '_PhpScoper5edc98a7cce2\\Illuminate\\Contracts\\Console\\Kernel', '*'), new \Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Auth', '*', '_PhpScoper5edc98a7cce2\\Illuminate\\Auth\\AuthManager', '*'), new \Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Blade', '*', '_PhpScoper5edc98a7cce2\\Illuminate\\View\\Compilers\\BladeCompiler', '*'), new \Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Broadcast', '*', '_PhpScoper5edc98a7cce2\\Illuminate\\Contracts\\Broadcasting\\Factory', '*'), new \Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Bus', '*', '_PhpScoper5edc98a7cce2\\Illuminate\\Contracts\\Bus\\Dispatcher', '*'), new \Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Cache', '*', '_PhpScoper5edc98a7cce2\\Illuminate\\Cache\\CacheManager', '*'), new \Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Config', '*', '_PhpScoper5edc98a7cce2\\Illuminate\\Config\\Repository', '*'), new \Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Cookie', '*', '_PhpScoper5edc98a7cce2\\Illuminate\\Cookie\\CookieJar', '*'), new \Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Crypt', '*', '_PhpScoper5edc98a7cce2\\Illuminate\\Encryption\\Encrypter', '*'), new \Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\DB', '*', '_PhpScoper5edc98a7cce2\\Illuminate\\Database\\DatabaseManager', '*'), new \Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Event', '*', '_PhpScoper5edc98a7cce2\\Illuminate\\Events\\Dispatcher', '*'), new \Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\File', '*', '_PhpScoper5edc98a7cce2\\Illuminate\\Filesystem\\Filesystem', '*'), new \Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Gate', '*', '_PhpScoper5edc98a7cce2\\Illuminate\\Contracts\\Auth\\Access\\Gate', '*'), new \Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Hash', '*', '_PhpScoper5edc98a7cce2\\Illuminate\\Contracts\\Hashing\\Hasher', '*'), new \Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Lang', '*', '_PhpScoper5edc98a7cce2\\Illuminate\\Translation\\Translator', '*'), new \Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Log', '*', '_PhpScoper5edc98a7cce2\\Illuminate\\Log\\LogManager', '*'), new \Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Mail', '*', '_PhpScoper5edc98a7cce2\\Illuminate\\Mail\\Mailer', '*'), new \Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Notification', '*', '_PhpScoper5edc98a7cce2\\Illuminate\\Notifications\\ChannelManager', '*'), new \Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Password', '*', '_PhpScoper5edc98a7cce2\\Illuminate\\Auth\\Passwords\\PasswordBrokerManager', '*'), new \Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Queue', '*', '_PhpScoper5edc98a7cce2\\Illuminate\\Queue\\QueueManager', '*'), new \Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Redirect', '*', '_PhpScoper5edc98a7cce2\\Illuminate\\Routing\\Redirector', '*'), new \Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Redis', '*', '_PhpScoper5edc98a7cce2\\Illuminate\\Redis\\RedisManager', '*'), new \Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Request', '*', '_PhpScoper5edc98a7cce2\\Illuminate\\Http\\Request', '*'), new \Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Response', '*', '_PhpScoper5edc98a7cce2\\Illuminate\\Contracts\\Routing\\ResponseFactory', '*'), new \Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Route', '*', '_PhpScoper5edc98a7cce2\\Illuminate\\Routing\\Router', '*'), new \Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Schema', '*', '_PhpScoper5edc98a7cce2\\Illuminate\\Database\\Schema\\Builder', '*'), new \Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Session', '*', '_PhpScoper5edc98a7cce2\\Illuminate\\Session\\SessionManager', '*'), new \Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Storage', '*', '_PhpScoper5edc98a7cce2\\Illuminate\\Filesystem\\FilesystemManager', '*'), new \Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\URL', '*', '_PhpScoper5edc98a7cce2\\Illuminate\\Routing\\UrlGenerator', '*'), new \Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Validator', '*', '_PhpScoper5edc98a7cce2\\Illuminate\\Validation\\Factory', '*'), new \Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\View', '*', '_PhpScoper5edc98a7cce2\\Illuminate\\View\\Factory', '*')])]]);
    $services->set(\Rector\Laravel\Rector\StaticCall\RequestStaticValidateToInjectRector::class);
    // @see https://github.com/laravel/framework/blob/78828bc779e410e03cc6465f002b834eadf160d2/src/Illuminate/Foundation/helpers.php#L959
    // @see https://gist.github.com/barryvdh/bb6ffc5d11e0a75dba67
    $services->set(\Rector\Transform\Rector\FuncCall\ArgumentFuncCallToMethodCallRector::class)->call('configure', [[\Rector\Transform\Rector\FuncCall\ArgumentFuncCallToMethodCallRector::FUNCTIONS_TO_METHOD_CALLS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        new \Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('auth', '_PhpScoper5edc98a7cce2\\Illuminate\\Contracts\\Auth\\Guard'),
        new \Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('policy', '_PhpScoper5edc98a7cce2\\Illuminate\\Contracts\\Auth\\Access\\Gate', 'getPolicyFor'),
        new \Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('cookie', '_PhpScoper5edc98a7cce2\\Illuminate\\Contracts\\Cookie\\Factory', 'make'),
        // router
        new \Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('put', '_PhpScoper5edc98a7cce2\\Illuminate\\Routing\\Router', 'put'),
        new \Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('get', '_PhpScoper5edc98a7cce2\\Illuminate\\Routing\\Router', 'get'),
        new \Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('post', '_PhpScoper5edc98a7cce2\\Illuminate\\Routing\\Router', 'post'),
        new \Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('patch', '_PhpScoper5edc98a7cce2\\Illuminate\\Routing\\Router', 'patch'),
        new \Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('delete', '_PhpScoper5edc98a7cce2\\Illuminate\\Routing\\Router', 'delete'),
        new \Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('resource', '_PhpScoper5edc98a7cce2\\Illuminate\\Routing\\Router', 'resource'),
        new \Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('response', '_PhpScoper5edc98a7cce2\\Illuminate\\Contracts\\Routing\\ResponseFactory', 'make'),
        new \Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('info', '_PhpScoper5edc98a7cce2\\Illuminate\\Log\\Writer', 'info'),
        new \Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('view', '_PhpScoper5edc98a7cce2\\Illuminate\\Contracts\\View\\Factory', 'make'),
        new \Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('bcrypt', '_PhpScoper5edc98a7cce2\\Illuminate\\Hashing\\BcryptHasher', 'make'),
        new \Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('redirect', '_PhpScoper5edc98a7cce2\\Illuminate\\Routing\\Redirector', 'back'),
        new \Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('broadcast', '_PhpScoper5edc98a7cce2\\Illuminate\\Contracts\\Broadcasting\\Factory', 'event'),
        new \Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('event', '_PhpScoper5edc98a7cce2\\Illuminate\\Events\\Dispatcher', 'dispatch'),
        new \Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('dispatch', '_PhpScoper5edc98a7cce2\\Illuminate\\Events\\Dispatcher', 'dispatch'),
        new \Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('route', '_PhpScoper5edc98a7cce2\\Illuminate\\Routing\\UrlGenerator', 'route'),
        new \Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('asset', '_PhpScoper5edc98a7cce2\\Illuminate\\Routing\\UrlGenerator', 'asset'),
        new \Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('url', '_PhpScoper5edc98a7cce2\\Illuminate\\Contracts\\Routing\\UrlGenerator', 'to'),
        new \Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('action', '_PhpScoper5edc98a7cce2\\Illuminate\\Routing\\UrlGenerator', 'action'),
        new \Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('trans', '_PhpScoper5edc98a7cce2\\Illuminate\\Translation\\Translator', 'trans'),
        new \Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('trans_choice', '_PhpScoper5edc98a7cce2\\Illuminate\\Translation\\Translator', 'transChoice'),
        new \Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('logger', '_PhpScoper5edc98a7cce2\\Illuminate\\Log\\Writer', 'debug'),
        new \Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('back', '_PhpScoper5edc98a7cce2\\Illuminate\\Routing\\Redirector', 'back', 'back'),
    ]), \Rector\Transform\Rector\FuncCall\ArgumentFuncCallToMethodCallRector::ARRAY_FUNCTIONS_TO_METHOD_CALLS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Transform\ValueObject\ArrayFuncCallToMethodCall('config', '_PhpScoper5edc98a7cce2\\Illuminate\\Contracts\\Config\\Repository', 'set', 'get'), new \Rector\Transform\ValueObject\ArrayFuncCallToMethodCall('session', '_PhpScoper5edc98a7cce2\\Illuminate\\Session\\SessionManager', 'put', 'get')])]]);
    $services->set(\Rector\Generic\Rector\FuncCall\FuncCallToNewRector::class)->call('configure', [[\Rector\Generic\Rector\FuncCall\FuncCallToNewRector::FUNCTION_TO_NEW => ['collect' => '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Collection']]]);
    $services->set(\Rector\Laravel\Rector\FuncCall\HelperFuncCallToFacadeClassRector::class);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['App' => '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\App', 'Artisan' => '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Artisan', 'Auth' => '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Auth', 'Blade' => '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Blade', 'Broadcast' => '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Broadcast', 'Bus' => '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Bus', 'Cache' => '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Cache', 'Config' => '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Config', 'Cookie' => '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Cookie', 'Crypt' => '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Crypt', 'DB' => '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\DB', 'Date' => '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Date', 'Event' => '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Event', 'Facade' => '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Facade', 'File' => '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\File', 'Gate' => '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Gate', 'Hash' => '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Hash', 'Http' => '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Http', 'Lang' => '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Lang', 'Log' => '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Log', 'Mail' => '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Mail', 'Notification' => '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Notification', 'Password' => '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Password', 'Queue' => '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Queue', 'RateLimiter' => '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\RateLimiter', 'Redirect' => '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Redirect', 'Redis' => '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Redis', 'Request' => '_PhpScoper5edc98a7cce2\\Illuminate\\Http\\Request', 'Response' => '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Response', 'Route' => '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Route', 'Schema' => '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Schema', 'Session' => '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Session', 'Storage' => '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Storage', 'URL' => '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\URL', 'Validator' => '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Validator', 'View' => '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\View']]]);
};
