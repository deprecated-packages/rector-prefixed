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
        'App' => '_PhpScoper267b3276efc2\\Cake\\Core\\App',
        'AppController' => '_PhpScoper267b3276efc2\\App\\Controller\\AppController',
        'AppHelper' => '_PhpScoper267b3276efc2\\App\\View\\Helper\\AppHelper',
        'AppModel' => '_PhpScoper267b3276efc2\\App\\Model\\AppModel',
        'Cache' => '_PhpScoper267b3276efc2\\Cake\\Cache\\Cache',
        'CakeEventListener' => '_PhpScoper267b3276efc2\\Cake\\Event\\EventListener',
        'CakeLog' => '_PhpScoper267b3276efc2\\Cake\\Log\\Log',
        'CakePlugin' => '_PhpScoper267b3276efc2\\Cake\\Core\\Plugin',
        'CakeTestCase' => '_PhpScoper267b3276efc2\\Cake\\TestSuite\\TestCase',
        'CakeTestFixture' => '_PhpScoper267b3276efc2\\Cake\\TestSuite\\Fixture\\TestFixture',
        'Component' => '_PhpScoper267b3276efc2\\Cake\\Controller\\Component',
        'ComponentRegistry' => '_PhpScoper267b3276efc2\\Cake\\Controller\\ComponentRegistry',
        'Configure' => '_PhpScoper267b3276efc2\\Cake\\Core\\Configure',
        'ConnectionManager' => '_PhpScoper267b3276efc2\\Cake\\Database\\ConnectionManager',
        'Controller' => '_PhpScoper267b3276efc2\\Cake\\Controller\\Controller',
        'Debugger' => '_PhpScoper267b3276efc2\\Cake\\Error\\Debugger',
        'ExceptionRenderer' => '_PhpScoper267b3276efc2\\Cake\\Error\\ExceptionRenderer',
        'Helper' => '_PhpScoper267b3276efc2\\Cake\\View\\Helper',
        'HelperRegistry' => '_PhpScoper267b3276efc2\\Cake\\View\\HelperRegistry',
        'Inflector' => '_PhpScoper267b3276efc2\\Cake\\Utility\\Inflector',
        'Model' => '_PhpScoper267b3276efc2\\Cake\\Model\\Model',
        'ModelBehavior' => '_PhpScoper267b3276efc2\\Cake\\Model\\Behavior',
        'Object' => '_PhpScoper267b3276efc2\\Cake\\Core\\Object',
        'Router' => '_PhpScoper267b3276efc2\\Cake\\Routing\\Router',
        'Shell' => '_PhpScoper267b3276efc2\\Cake\\Console\\Shell',
        'View' => '_PhpScoper267b3276efc2\\Cake\\View\\View',
        // Also apply to already renamed ones
        'Log' => '_PhpScoper267b3276efc2\\Cake\\Log\\Log',
        'Plugin' => '_PhpScoper267b3276efc2\\Cake\\Core\\Plugin',
        'TestCase' => '_PhpScoper267b3276efc2\\Cake\\TestSuite\\TestCase',
        'TestFixture' => '_PhpScoper267b3276efc2\\Cake\\TestSuite\\Fixture\\TestFixture',
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
