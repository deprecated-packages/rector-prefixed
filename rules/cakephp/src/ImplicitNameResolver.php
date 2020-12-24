<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\CakePHP;

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
        'App' => '_PhpScoper2a4e7ab1ecbc\\Cake\\Core\\App',
        'AppController' => '_PhpScoper2a4e7ab1ecbc\\App\\Controller\\AppController',
        'AppHelper' => '_PhpScoper2a4e7ab1ecbc\\App\\View\\Helper\\AppHelper',
        'AppModel' => '_PhpScoper2a4e7ab1ecbc\\App\\Model\\AppModel',
        'Cache' => '_PhpScoper2a4e7ab1ecbc\\Cake\\Cache\\Cache',
        'CakeEventListener' => '_PhpScoper2a4e7ab1ecbc\\Cake\\Event\\EventListener',
        'CakeLog' => '_PhpScoper2a4e7ab1ecbc\\Cake\\Log\\Log',
        'CakePlugin' => '_PhpScoper2a4e7ab1ecbc\\Cake\\Core\\Plugin',
        'CakeTestCase' => '_PhpScoper2a4e7ab1ecbc\\Cake\\TestSuite\\TestCase',
        'CakeTestFixture' => '_PhpScoper2a4e7ab1ecbc\\Cake\\TestSuite\\Fixture\\TestFixture',
        'Component' => '_PhpScoper2a4e7ab1ecbc\\Cake\\Controller\\Component',
        'ComponentRegistry' => '_PhpScoper2a4e7ab1ecbc\\Cake\\Controller\\ComponentRegistry',
        'Configure' => '_PhpScoper2a4e7ab1ecbc\\Cake\\Core\\Configure',
        'ConnectionManager' => '_PhpScoper2a4e7ab1ecbc\\Cake\\Database\\ConnectionManager',
        'Controller' => '_PhpScoper2a4e7ab1ecbc\\Cake\\Controller\\Controller',
        'Debugger' => '_PhpScoper2a4e7ab1ecbc\\Cake\\Error\\Debugger',
        'ExceptionRenderer' => '_PhpScoper2a4e7ab1ecbc\\Cake\\Error\\ExceptionRenderer',
        'Helper' => '_PhpScoper2a4e7ab1ecbc\\Cake\\View\\Helper',
        'HelperRegistry' => '_PhpScoper2a4e7ab1ecbc\\Cake\\View\\HelperRegistry',
        'Inflector' => '_PhpScoper2a4e7ab1ecbc\\Cake\\Utility\\Inflector',
        'Model' => '_PhpScoper2a4e7ab1ecbc\\Cake\\Model\\Model',
        'ModelBehavior' => '_PhpScoper2a4e7ab1ecbc\\Cake\\Model\\Behavior',
        'Object' => '_PhpScoper2a4e7ab1ecbc\\Cake\\Core\\Object',
        'Router' => '_PhpScoper2a4e7ab1ecbc\\Cake\\Routing\\Router',
        'Shell' => '_PhpScoper2a4e7ab1ecbc\\Cake\\Console\\Shell',
        'View' => '_PhpScoper2a4e7ab1ecbc\\Cake\\View\\View',
        // Also apply to already renamed ones
        'Log' => '_PhpScoper2a4e7ab1ecbc\\Cake\\Log\\Log',
        'Plugin' => '_PhpScoper2a4e7ab1ecbc\\Cake\\Core\\Plugin',
        'TestCase' => '_PhpScoper2a4e7ab1ecbc\\Cake\\TestSuite\\TestCase',
        'TestFixture' => '_PhpScoper2a4e7ab1ecbc\\Cake\\TestSuite\\Fixture\\TestFixture',
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
