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
        'App' => '_PhpScoper17db12703726\\Cake\\Core\\App',
        'AppController' => '_PhpScoper17db12703726\\App\\Controller\\AppController',
        'AppHelper' => '_PhpScoper17db12703726\\App\\View\\Helper\\AppHelper',
        'AppModel' => '_PhpScoper17db12703726\\App\\Model\\AppModel',
        'Cache' => '_PhpScoper17db12703726\\Cake\\Cache\\Cache',
        'CakeEventListener' => '_PhpScoper17db12703726\\Cake\\Event\\EventListener',
        'CakeLog' => '_PhpScoper17db12703726\\Cake\\Log\\Log',
        'CakePlugin' => '_PhpScoper17db12703726\\Cake\\Core\\Plugin',
        'CakeTestCase' => '_PhpScoper17db12703726\\Cake\\TestSuite\\TestCase',
        'CakeTestFixture' => '_PhpScoper17db12703726\\Cake\\TestSuite\\Fixture\\TestFixture',
        'Component' => '_PhpScoper17db12703726\\Cake\\Controller\\Component',
        'ComponentRegistry' => '_PhpScoper17db12703726\\Cake\\Controller\\ComponentRegistry',
        'Configure' => '_PhpScoper17db12703726\\Cake\\Core\\Configure',
        'ConnectionManager' => '_PhpScoper17db12703726\\Cake\\Database\\ConnectionManager',
        'Controller' => '_PhpScoper17db12703726\\Cake\\Controller\\Controller',
        'Debugger' => '_PhpScoper17db12703726\\Cake\\Error\\Debugger',
        'ExceptionRenderer' => '_PhpScoper17db12703726\\Cake\\Error\\ExceptionRenderer',
        'Helper' => '_PhpScoper17db12703726\\Cake\\View\\Helper',
        'HelperRegistry' => '_PhpScoper17db12703726\\Cake\\View\\HelperRegistry',
        'Inflector' => '_PhpScoper17db12703726\\Cake\\Utility\\Inflector',
        'Model' => '_PhpScoper17db12703726\\Cake\\Model\\Model',
        'ModelBehavior' => '_PhpScoper17db12703726\\Cake\\Model\\Behavior',
        'Object' => '_PhpScoper17db12703726\\Cake\\Core\\Object',
        'Router' => '_PhpScoper17db12703726\\Cake\\Routing\\Router',
        'Shell' => '_PhpScoper17db12703726\\Cake\\Console\\Shell',
        'View' => '_PhpScoper17db12703726\\Cake\\View\\View',
        // Also apply to already renamed ones
        'Log' => '_PhpScoper17db12703726\\Cake\\Log\\Log',
        'Plugin' => '_PhpScoper17db12703726\\Cake\\Core\\Plugin',
        'TestCase' => '_PhpScoper17db12703726\\Cake\\TestSuite\\TestCase',
        'TestFixture' => '_PhpScoper17db12703726\\Cake\\TestSuite\\Fixture\\TestFixture',
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
