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
        'App' => '_PhpScoperbf340cb0be9d\\Cake\\Core\\App',
        'AppController' => '_PhpScoperbf340cb0be9d\\App\\Controller\\AppController',
        'AppHelper' => '_PhpScoperbf340cb0be9d\\App\\View\\Helper\\AppHelper',
        'AppModel' => '_PhpScoperbf340cb0be9d\\App\\Model\\AppModel',
        'Cache' => '_PhpScoperbf340cb0be9d\\Cake\\Cache\\Cache',
        'CakeEventListener' => '_PhpScoperbf340cb0be9d\\Cake\\Event\\EventListener',
        'CakeLog' => '_PhpScoperbf340cb0be9d\\Cake\\Log\\Log',
        'CakePlugin' => '_PhpScoperbf340cb0be9d\\Cake\\Core\\Plugin',
        'CakeTestCase' => '_PhpScoperbf340cb0be9d\\Cake\\TestSuite\\TestCase',
        'CakeTestFixture' => '_PhpScoperbf340cb0be9d\\Cake\\TestSuite\\Fixture\\TestFixture',
        'Component' => '_PhpScoperbf340cb0be9d\\Cake\\Controller\\Component',
        'ComponentRegistry' => '_PhpScoperbf340cb0be9d\\Cake\\Controller\\ComponentRegistry',
        'Configure' => '_PhpScoperbf340cb0be9d\\Cake\\Core\\Configure',
        'ConnectionManager' => '_PhpScoperbf340cb0be9d\\Cake\\Database\\ConnectionManager',
        'Controller' => '_PhpScoperbf340cb0be9d\\Cake\\Controller\\Controller',
        'Debugger' => '_PhpScoperbf340cb0be9d\\Cake\\Error\\Debugger',
        'ExceptionRenderer' => '_PhpScoperbf340cb0be9d\\Cake\\Error\\ExceptionRenderer',
        'Helper' => '_PhpScoperbf340cb0be9d\\Cake\\View\\Helper',
        'HelperRegistry' => '_PhpScoperbf340cb0be9d\\Cake\\View\\HelperRegistry',
        'Inflector' => '_PhpScoperbf340cb0be9d\\Cake\\Utility\\Inflector',
        'Model' => '_PhpScoperbf340cb0be9d\\Cake\\Model\\Model',
        'ModelBehavior' => '_PhpScoperbf340cb0be9d\\Cake\\Model\\Behavior',
        'Object' => '_PhpScoperbf340cb0be9d\\Cake\\Core\\Object',
        'Router' => '_PhpScoperbf340cb0be9d\\Cake\\Routing\\Router',
        'Shell' => '_PhpScoperbf340cb0be9d\\Cake\\Console\\Shell',
        'View' => '_PhpScoperbf340cb0be9d\\Cake\\View\\View',
        // Also apply to already renamed ones
        'Log' => '_PhpScoperbf340cb0be9d\\Cake\\Log\\Log',
        'Plugin' => '_PhpScoperbf340cb0be9d\\Cake\\Core\\Plugin',
        'TestCase' => '_PhpScoperbf340cb0be9d\\Cake\\TestSuite\\TestCase',
        'TestFixture' => '_PhpScoperbf340cb0be9d\\Cake\\TestSuite\\Fixture\\TestFixture',
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
