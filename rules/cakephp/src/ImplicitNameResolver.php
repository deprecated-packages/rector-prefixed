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
        'App' => '_PhpScoper5edc98a7cce2\\Cake\\Core\\App',
        'AppController' => '_PhpScoper5edc98a7cce2\\App\\Controller\\AppController',
        'AppHelper' => '_PhpScoper5edc98a7cce2\\App\\View\\Helper\\AppHelper',
        'AppModel' => '_PhpScoper5edc98a7cce2\\App\\Model\\AppModel',
        'Cache' => '_PhpScoper5edc98a7cce2\\Cake\\Cache\\Cache',
        'CakeEventListener' => '_PhpScoper5edc98a7cce2\\Cake\\Event\\EventListener',
        'CakeLog' => '_PhpScoper5edc98a7cce2\\Cake\\Log\\Log',
        'CakePlugin' => '_PhpScoper5edc98a7cce2\\Cake\\Core\\Plugin',
        'CakeTestCase' => '_PhpScoper5edc98a7cce2\\Cake\\TestSuite\\TestCase',
        'CakeTestFixture' => '_PhpScoper5edc98a7cce2\\Cake\\TestSuite\\Fixture\\TestFixture',
        'Component' => '_PhpScoper5edc98a7cce2\\Cake\\Controller\\Component',
        'ComponentRegistry' => '_PhpScoper5edc98a7cce2\\Cake\\Controller\\ComponentRegistry',
        'Configure' => '_PhpScoper5edc98a7cce2\\Cake\\Core\\Configure',
        'ConnectionManager' => '_PhpScoper5edc98a7cce2\\Cake\\Database\\ConnectionManager',
        'Controller' => '_PhpScoper5edc98a7cce2\\Cake\\Controller\\Controller',
        'Debugger' => '_PhpScoper5edc98a7cce2\\Cake\\Error\\Debugger',
        'ExceptionRenderer' => '_PhpScoper5edc98a7cce2\\Cake\\Error\\ExceptionRenderer',
        'Helper' => '_PhpScoper5edc98a7cce2\\Cake\\View\\Helper',
        'HelperRegistry' => '_PhpScoper5edc98a7cce2\\Cake\\View\\HelperRegistry',
        'Inflector' => '_PhpScoper5edc98a7cce2\\Cake\\Utility\\Inflector',
        'Model' => '_PhpScoper5edc98a7cce2\\Cake\\Model\\Model',
        'ModelBehavior' => '_PhpScoper5edc98a7cce2\\Cake\\Model\\Behavior',
        'Object' => '_PhpScoper5edc98a7cce2\\Cake\\Core\\Object',
        'Router' => '_PhpScoper5edc98a7cce2\\Cake\\Routing\\Router',
        'Shell' => '_PhpScoper5edc98a7cce2\\Cake\\Console\\Shell',
        'View' => '_PhpScoper5edc98a7cce2\\Cake\\View\\View',
        // Also apply to already renamed ones
        'Log' => '_PhpScoper5edc98a7cce2\\Cake\\Log\\Log',
        'Plugin' => '_PhpScoper5edc98a7cce2\\Cake\\Core\\Plugin',
        'TestCase' => '_PhpScoper5edc98a7cce2\\Cake\\TestSuite\\TestCase',
        'TestFixture' => '_PhpScoper5edc98a7cce2\\Cake\\TestSuite\\Fixture\\TestFixture',
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
