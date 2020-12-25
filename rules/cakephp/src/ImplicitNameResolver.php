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
        'App' => '_PhpScoper567b66d83109\\Cake\\Core\\App',
        'AppController' => '_PhpScoper567b66d83109\\App\\Controller\\AppController',
        'AppHelper' => '_PhpScoper567b66d83109\\App\\View\\Helper\\AppHelper',
        'AppModel' => '_PhpScoper567b66d83109\\App\\Model\\AppModel',
        'Cache' => '_PhpScoper567b66d83109\\Cake\\Cache\\Cache',
        'CakeEventListener' => '_PhpScoper567b66d83109\\Cake\\Event\\EventListener',
        'CakeLog' => '_PhpScoper567b66d83109\\Cake\\Log\\Log',
        'CakePlugin' => '_PhpScoper567b66d83109\\Cake\\Core\\Plugin',
        'CakeTestCase' => '_PhpScoper567b66d83109\\Cake\\TestSuite\\TestCase',
        'CakeTestFixture' => '_PhpScoper567b66d83109\\Cake\\TestSuite\\Fixture\\TestFixture',
        'Component' => '_PhpScoper567b66d83109\\Cake\\Controller\\Component',
        'ComponentRegistry' => '_PhpScoper567b66d83109\\Cake\\Controller\\ComponentRegistry',
        'Configure' => '_PhpScoper567b66d83109\\Cake\\Core\\Configure',
        'ConnectionManager' => '_PhpScoper567b66d83109\\Cake\\Database\\ConnectionManager',
        'Controller' => '_PhpScoper567b66d83109\\Cake\\Controller\\Controller',
        'Debugger' => '_PhpScoper567b66d83109\\Cake\\Error\\Debugger',
        'ExceptionRenderer' => '_PhpScoper567b66d83109\\Cake\\Error\\ExceptionRenderer',
        'Helper' => '_PhpScoper567b66d83109\\Cake\\View\\Helper',
        'HelperRegistry' => '_PhpScoper567b66d83109\\Cake\\View\\HelperRegistry',
        'Inflector' => '_PhpScoper567b66d83109\\Cake\\Utility\\Inflector',
        'Model' => '_PhpScoper567b66d83109\\Cake\\Model\\Model',
        'ModelBehavior' => '_PhpScoper567b66d83109\\Cake\\Model\\Behavior',
        'Object' => '_PhpScoper567b66d83109\\Cake\\Core\\Object',
        'Router' => '_PhpScoper567b66d83109\\Cake\\Routing\\Router',
        'Shell' => '_PhpScoper567b66d83109\\Cake\\Console\\Shell',
        'View' => '_PhpScoper567b66d83109\\Cake\\View\\View',
        // Also apply to already renamed ones
        'Log' => '_PhpScoper567b66d83109\\Cake\\Log\\Log',
        'Plugin' => '_PhpScoper567b66d83109\\Cake\\Core\\Plugin',
        'TestCase' => '_PhpScoper567b66d83109\\Cake\\TestSuite\\TestCase',
        'TestFixture' => '_PhpScoper567b66d83109\\Cake\\TestSuite\\Fixture\\TestFixture',
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
