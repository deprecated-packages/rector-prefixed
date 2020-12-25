<?php

declare (strict_types=1);
namespace Rector\CakePHP;

/**
 * @inspired https://github.com/cakephp/upgrade/blob/756410c8b7d5aff9daec3fa1fe750a3858d422ac/src/Shell/Task/AppUsesTask.php
 */
final class ImplicitNameResolver
{
    /**
     * A map of old => new for use statements that are missing
     *
     * @var string[]
     */
    private const IMPLICIT_MAP = [
        'App' => '_PhpScoper8b9c402c5f32\\Cake\\Core\\App',
        'AppController' => '_PhpScoper8b9c402c5f32\\App\\Controller\\AppController',
        'AppHelper' => '_PhpScoper8b9c402c5f32\\App\\View\\Helper\\AppHelper',
        'AppModel' => '_PhpScoper8b9c402c5f32\\App\\Model\\AppModel',
        'Cache' => '_PhpScoper8b9c402c5f32\\Cake\\Cache\\Cache',
        'CakeEventListener' => '_PhpScoper8b9c402c5f32\\Cake\\Event\\EventListener',
        'CakeLog' => '_PhpScoper8b9c402c5f32\\Cake\\Log\\Log',
        'CakePlugin' => '_PhpScoper8b9c402c5f32\\Cake\\Core\\Plugin',
        'CakeTestCase' => '_PhpScoper8b9c402c5f32\\Cake\\TestSuite\\TestCase',
        'CakeTestFixture' => '_PhpScoper8b9c402c5f32\\Cake\\TestSuite\\Fixture\\TestFixture',
        'Component' => '_PhpScoper8b9c402c5f32\\Cake\\Controller\\Component',
        'ComponentRegistry' => '_PhpScoper8b9c402c5f32\\Cake\\Controller\\ComponentRegistry',
        'Configure' => '_PhpScoper8b9c402c5f32\\Cake\\Core\\Configure',
        'ConnectionManager' => '_PhpScoper8b9c402c5f32\\Cake\\Database\\ConnectionManager',
        'Controller' => '_PhpScoper8b9c402c5f32\\Cake\\Controller\\Controller',
        'Debugger' => '_PhpScoper8b9c402c5f32\\Cake\\Error\\Debugger',
        'ExceptionRenderer' => '_PhpScoper8b9c402c5f32\\Cake\\Error\\ExceptionRenderer',
        'Helper' => '_PhpScoper8b9c402c5f32\\Cake\\View\\Helper',
        'HelperRegistry' => '_PhpScoper8b9c402c5f32\\Cake\\View\\HelperRegistry',
        'Inflector' => '_PhpScoper8b9c402c5f32\\Cake\\Utility\\Inflector',
        'Model' => '_PhpScoper8b9c402c5f32\\Cake\\Model\\Model',
        'ModelBehavior' => '_PhpScoper8b9c402c5f32\\Cake\\Model\\Behavior',
        'Object' => '_PhpScoper8b9c402c5f32\\Cake\\Core\\Object',
        'Router' => '_PhpScoper8b9c402c5f32\\Cake\\Routing\\Router',
        'Shell' => '_PhpScoper8b9c402c5f32\\Cake\\Console\\Shell',
        'View' => '_PhpScoper8b9c402c5f32\\Cake\\View\\View',
        // Also apply to already renamed ones
        'Log' => '_PhpScoper8b9c402c5f32\\Cake\\Log\\Log',
        'Plugin' => '_PhpScoper8b9c402c5f32\\Cake\\Core\\Plugin',
        'TestCase' => '_PhpScoper8b9c402c5f32\\Cake\\TestSuite\\TestCase',
        'TestFixture' => '_PhpScoper8b9c402c5f32\\Cake\\TestSuite\\Fixture\\TestFixture',
    ];
    /**
     * This value used to be directory
     * So "/" in path should be "\" in namespace
     */
    public function resolve(string $shortClass) : ?string
    {
        return self::IMPLICIT_MAP[$shortClass] ?? null;
    }
}
