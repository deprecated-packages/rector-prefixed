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
        'App' => '_PhpScoper006a73f0e455\\Cake\\Core\\App',
        'AppController' => '_PhpScoper006a73f0e455\\App\\Controller\\AppController',
        'AppHelper' => '_PhpScoper006a73f0e455\\App\\View\\Helper\\AppHelper',
        'AppModel' => '_PhpScoper006a73f0e455\\App\\Model\\AppModel',
        'Cache' => '_PhpScoper006a73f0e455\\Cake\\Cache\\Cache',
        'CakeEventListener' => '_PhpScoper006a73f0e455\\Cake\\Event\\EventListener',
        'CakeLog' => '_PhpScoper006a73f0e455\\Cake\\Log\\Log',
        'CakePlugin' => '_PhpScoper006a73f0e455\\Cake\\Core\\Plugin',
        'CakeTestCase' => '_PhpScoper006a73f0e455\\Cake\\TestSuite\\TestCase',
        'CakeTestFixture' => '_PhpScoper006a73f0e455\\Cake\\TestSuite\\Fixture\\TestFixture',
        'Component' => '_PhpScoper006a73f0e455\\Cake\\Controller\\Component',
        'ComponentRegistry' => '_PhpScoper006a73f0e455\\Cake\\Controller\\ComponentRegistry',
        'Configure' => '_PhpScoper006a73f0e455\\Cake\\Core\\Configure',
        'ConnectionManager' => '_PhpScoper006a73f0e455\\Cake\\Database\\ConnectionManager',
        'Controller' => '_PhpScoper006a73f0e455\\Cake\\Controller\\Controller',
        'Debugger' => '_PhpScoper006a73f0e455\\Cake\\Error\\Debugger',
        'ExceptionRenderer' => '_PhpScoper006a73f0e455\\Cake\\Error\\ExceptionRenderer',
        'Helper' => '_PhpScoper006a73f0e455\\Cake\\View\\Helper',
        'HelperRegistry' => '_PhpScoper006a73f0e455\\Cake\\View\\HelperRegistry',
        'Inflector' => '_PhpScoper006a73f0e455\\Cake\\Utility\\Inflector',
        'Model' => '_PhpScoper006a73f0e455\\Cake\\Model\\Model',
        'ModelBehavior' => '_PhpScoper006a73f0e455\\Cake\\Model\\Behavior',
        'Object' => '_PhpScoper006a73f0e455\\Cake\\Core\\Object',
        'Router' => '_PhpScoper006a73f0e455\\Cake\\Routing\\Router',
        'Shell' => '_PhpScoper006a73f0e455\\Cake\\Console\\Shell',
        'View' => '_PhpScoper006a73f0e455\\Cake\\View\\View',
        // Also apply to already renamed ones
        'Log' => '_PhpScoper006a73f0e455\\Cake\\Log\\Log',
        'Plugin' => '_PhpScoper006a73f0e455\\Cake\\Core\\Plugin',
        'TestCase' => '_PhpScoper006a73f0e455\\Cake\\TestSuite\\TestCase',
        'TestFixture' => '_PhpScoper006a73f0e455\\Cake\\TestSuite\\Fixture\\TestFixture',
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
