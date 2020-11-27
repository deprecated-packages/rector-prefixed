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
        'App' => '_PhpScopera143bcca66cb\\Cake\\Core\\App',
        'AppController' => '_PhpScopera143bcca66cb\\App\\Controller\\AppController',
        'AppHelper' => '_PhpScopera143bcca66cb\\App\\View\\Helper\\AppHelper',
        'AppModel' => '_PhpScopera143bcca66cb\\App\\Model\\AppModel',
        'Cache' => '_PhpScopera143bcca66cb\\Cake\\Cache\\Cache',
        'CakeEventListener' => '_PhpScopera143bcca66cb\\Cake\\Event\\EventListener',
        'CakeLog' => '_PhpScopera143bcca66cb\\Cake\\Log\\Log',
        'CakePlugin' => '_PhpScopera143bcca66cb\\Cake\\Core\\Plugin',
        'CakeTestCase' => '_PhpScopera143bcca66cb\\Cake\\TestSuite\\TestCase',
        'CakeTestFixture' => '_PhpScopera143bcca66cb\\Cake\\TestSuite\\Fixture\\TestFixture',
        'Component' => '_PhpScopera143bcca66cb\\Cake\\Controller\\Component',
        'ComponentRegistry' => '_PhpScopera143bcca66cb\\Cake\\Controller\\ComponentRegistry',
        'Configure' => '_PhpScopera143bcca66cb\\Cake\\Core\\Configure',
        'ConnectionManager' => '_PhpScopera143bcca66cb\\Cake\\Database\\ConnectionManager',
        'Controller' => '_PhpScopera143bcca66cb\\Cake\\Controller\\Controller',
        'Debugger' => '_PhpScopera143bcca66cb\\Cake\\Error\\Debugger',
        'ExceptionRenderer' => '_PhpScopera143bcca66cb\\Cake\\Error\\ExceptionRenderer',
        'Helper' => '_PhpScopera143bcca66cb\\Cake\\View\\Helper',
        'HelperRegistry' => '_PhpScopera143bcca66cb\\Cake\\View\\HelperRegistry',
        'Inflector' => '_PhpScopera143bcca66cb\\Cake\\Utility\\Inflector',
        'Model' => '_PhpScopera143bcca66cb\\Cake\\Model\\Model',
        'ModelBehavior' => '_PhpScopera143bcca66cb\\Cake\\Model\\Behavior',
        'Object' => '_PhpScopera143bcca66cb\\Cake\\Core\\Object',
        'Router' => '_PhpScopera143bcca66cb\\Cake\\Routing\\Router',
        'Shell' => '_PhpScopera143bcca66cb\\Cake\\Console\\Shell',
        'View' => '_PhpScopera143bcca66cb\\Cake\\View\\View',
        // Also apply to already renamed ones
        'Log' => '_PhpScopera143bcca66cb\\Cake\\Log\\Log',
        'Plugin' => '_PhpScopera143bcca66cb\\Cake\\Core\\Plugin',
        'TestCase' => '_PhpScopera143bcca66cb\\Cake\\TestSuite\\TestCase',
        'TestFixture' => '_PhpScopera143bcca66cb\\Cake\\TestSuite\\Fixture\\TestFixture',
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
