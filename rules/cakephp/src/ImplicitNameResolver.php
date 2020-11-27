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
        'App' => '_PhpScoper88fe6e0ad041\\Cake\\Core\\App',
        'AppController' => '_PhpScoper88fe6e0ad041\\App\\Controller\\AppController',
        'AppHelper' => '_PhpScoper88fe6e0ad041\\App\\View\\Helper\\AppHelper',
        'AppModel' => '_PhpScoper88fe6e0ad041\\App\\Model\\AppModel',
        'Cache' => '_PhpScoper88fe6e0ad041\\Cake\\Cache\\Cache',
        'CakeEventListener' => '_PhpScoper88fe6e0ad041\\Cake\\Event\\EventListener',
        'CakeLog' => '_PhpScoper88fe6e0ad041\\Cake\\Log\\Log',
        'CakePlugin' => '_PhpScoper88fe6e0ad041\\Cake\\Core\\Plugin',
        'CakeTestCase' => '_PhpScoper88fe6e0ad041\\Cake\\TestSuite\\TestCase',
        'CakeTestFixture' => '_PhpScoper88fe6e0ad041\\Cake\\TestSuite\\Fixture\\TestFixture',
        'Component' => '_PhpScoper88fe6e0ad041\\Cake\\Controller\\Component',
        'ComponentRegistry' => '_PhpScoper88fe6e0ad041\\Cake\\Controller\\ComponentRegistry',
        'Configure' => '_PhpScoper88fe6e0ad041\\Cake\\Core\\Configure',
        'ConnectionManager' => '_PhpScoper88fe6e0ad041\\Cake\\Database\\ConnectionManager',
        'Controller' => '_PhpScoper88fe6e0ad041\\Cake\\Controller\\Controller',
        'Debugger' => '_PhpScoper88fe6e0ad041\\Cake\\Error\\Debugger',
        'ExceptionRenderer' => '_PhpScoper88fe6e0ad041\\Cake\\Error\\ExceptionRenderer',
        'Helper' => '_PhpScoper88fe6e0ad041\\Cake\\View\\Helper',
        'HelperRegistry' => '_PhpScoper88fe6e0ad041\\Cake\\View\\HelperRegistry',
        'Inflector' => '_PhpScoper88fe6e0ad041\\Cake\\Utility\\Inflector',
        'Model' => '_PhpScoper88fe6e0ad041\\Cake\\Model\\Model',
        'ModelBehavior' => '_PhpScoper88fe6e0ad041\\Cake\\Model\\Behavior',
        'Object' => '_PhpScoper88fe6e0ad041\\Cake\\Core\\Object',
        'Router' => '_PhpScoper88fe6e0ad041\\Cake\\Routing\\Router',
        'Shell' => '_PhpScoper88fe6e0ad041\\Cake\\Console\\Shell',
        'View' => '_PhpScoper88fe6e0ad041\\Cake\\View\\View',
        // Also apply to already renamed ones
        'Log' => '_PhpScoper88fe6e0ad041\\Cake\\Log\\Log',
        'Plugin' => '_PhpScoper88fe6e0ad041\\Cake\\Core\\Plugin',
        'TestCase' => '_PhpScoper88fe6e0ad041\\Cake\\TestSuite\\TestCase',
        'TestFixture' => '_PhpScoper88fe6e0ad041\\Cake\\TestSuite\\Fixture\\TestFixture',
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
