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
        'App' => '_PhpScoperfce0de0de1ce\\Cake\\Core\\App',
        'AppController' => '_PhpScoperfce0de0de1ce\\App\\Controller\\AppController',
        'AppHelper' => '_PhpScoperfce0de0de1ce\\App\\View\\Helper\\AppHelper',
        'AppModel' => '_PhpScoperfce0de0de1ce\\App\\Model\\AppModel',
        'Cache' => '_PhpScoperfce0de0de1ce\\Cake\\Cache\\Cache',
        'CakeEventListener' => '_PhpScoperfce0de0de1ce\\Cake\\Event\\EventListener',
        'CakeLog' => '_PhpScoperfce0de0de1ce\\Cake\\Log\\Log',
        'CakePlugin' => '_PhpScoperfce0de0de1ce\\Cake\\Core\\Plugin',
        'CakeTestCase' => '_PhpScoperfce0de0de1ce\\Cake\\TestSuite\\TestCase',
        'CakeTestFixture' => '_PhpScoperfce0de0de1ce\\Cake\\TestSuite\\Fixture\\TestFixture',
        'Component' => '_PhpScoperfce0de0de1ce\\Cake\\Controller\\Component',
        'ComponentRegistry' => '_PhpScoperfce0de0de1ce\\Cake\\Controller\\ComponentRegistry',
        'Configure' => '_PhpScoperfce0de0de1ce\\Cake\\Core\\Configure',
        'ConnectionManager' => '_PhpScoperfce0de0de1ce\\Cake\\Database\\ConnectionManager',
        'Controller' => '_PhpScoperfce0de0de1ce\\Cake\\Controller\\Controller',
        'Debugger' => '_PhpScoperfce0de0de1ce\\Cake\\Error\\Debugger',
        'ExceptionRenderer' => '_PhpScoperfce0de0de1ce\\Cake\\Error\\ExceptionRenderer',
        'Helper' => '_PhpScoperfce0de0de1ce\\Cake\\View\\Helper',
        'HelperRegistry' => '_PhpScoperfce0de0de1ce\\Cake\\View\\HelperRegistry',
        'Inflector' => '_PhpScoperfce0de0de1ce\\Cake\\Utility\\Inflector',
        'Model' => '_PhpScoperfce0de0de1ce\\Cake\\Model\\Model',
        'ModelBehavior' => '_PhpScoperfce0de0de1ce\\Cake\\Model\\Behavior',
        'Object' => '_PhpScoperfce0de0de1ce\\Cake\\Core\\Object',
        'Router' => '_PhpScoperfce0de0de1ce\\Cake\\Routing\\Router',
        'Shell' => '_PhpScoperfce0de0de1ce\\Cake\\Console\\Shell',
        'View' => '_PhpScoperfce0de0de1ce\\Cake\\View\\View',
        // Also apply to already renamed ones
        'Log' => '_PhpScoperfce0de0de1ce\\Cake\\Log\\Log',
        'Plugin' => '_PhpScoperfce0de0de1ce\\Cake\\Core\\Plugin',
        'TestCase' => '_PhpScoperfce0de0de1ce\\Cake\\TestSuite\\TestCase',
        'TestFixture' => '_PhpScoperfce0de0de1ce\\Cake\\TestSuite\\Fixture\\TestFixture',
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
