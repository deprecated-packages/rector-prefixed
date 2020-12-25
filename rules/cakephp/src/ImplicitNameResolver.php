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
        'App' => '_PhpScoperf18a0c41e2d2\\Cake\\Core\\App',
        'AppController' => '_PhpScoperf18a0c41e2d2\\App\\Controller\\AppController',
        'AppHelper' => '_PhpScoperf18a0c41e2d2\\App\\View\\Helper\\AppHelper',
        'AppModel' => '_PhpScoperf18a0c41e2d2\\App\\Model\\AppModel',
        'Cache' => '_PhpScoperf18a0c41e2d2\\Cake\\Cache\\Cache',
        'CakeEventListener' => '_PhpScoperf18a0c41e2d2\\Cake\\Event\\EventListener',
        'CakeLog' => '_PhpScoperf18a0c41e2d2\\Cake\\Log\\Log',
        'CakePlugin' => '_PhpScoperf18a0c41e2d2\\Cake\\Core\\Plugin',
        'CakeTestCase' => '_PhpScoperf18a0c41e2d2\\Cake\\TestSuite\\TestCase',
        'CakeTestFixture' => '_PhpScoperf18a0c41e2d2\\Cake\\TestSuite\\Fixture\\TestFixture',
        'Component' => '_PhpScoperf18a0c41e2d2\\Cake\\Controller\\Component',
        'ComponentRegistry' => '_PhpScoperf18a0c41e2d2\\Cake\\Controller\\ComponentRegistry',
        'Configure' => '_PhpScoperf18a0c41e2d2\\Cake\\Core\\Configure',
        'ConnectionManager' => '_PhpScoperf18a0c41e2d2\\Cake\\Database\\ConnectionManager',
        'Controller' => '_PhpScoperf18a0c41e2d2\\Cake\\Controller\\Controller',
        'Debugger' => '_PhpScoperf18a0c41e2d2\\Cake\\Error\\Debugger',
        'ExceptionRenderer' => '_PhpScoperf18a0c41e2d2\\Cake\\Error\\ExceptionRenderer',
        'Helper' => '_PhpScoperf18a0c41e2d2\\Cake\\View\\Helper',
        'HelperRegistry' => '_PhpScoperf18a0c41e2d2\\Cake\\View\\HelperRegistry',
        'Inflector' => '_PhpScoperf18a0c41e2d2\\Cake\\Utility\\Inflector',
        'Model' => '_PhpScoperf18a0c41e2d2\\Cake\\Model\\Model',
        'ModelBehavior' => '_PhpScoperf18a0c41e2d2\\Cake\\Model\\Behavior',
        'Object' => '_PhpScoperf18a0c41e2d2\\Cake\\Core\\Object',
        'Router' => '_PhpScoperf18a0c41e2d2\\Cake\\Routing\\Router',
        'Shell' => '_PhpScoperf18a0c41e2d2\\Cake\\Console\\Shell',
        'View' => '_PhpScoperf18a0c41e2d2\\Cake\\View\\View',
        // Also apply to already renamed ones
        'Log' => '_PhpScoperf18a0c41e2d2\\Cake\\Log\\Log',
        'Plugin' => '_PhpScoperf18a0c41e2d2\\Cake\\Core\\Plugin',
        'TestCase' => '_PhpScoperf18a0c41e2d2\\Cake\\TestSuite\\TestCase',
        'TestFixture' => '_PhpScoperf18a0c41e2d2\\Cake\\TestSuite\\Fixture\\TestFixture',
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
