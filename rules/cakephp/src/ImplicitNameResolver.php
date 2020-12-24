<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CakePHP;

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
        'App' => '_PhpScoper0a6b37af0871\\Cake\\Core\\App',
        'AppController' => '_PhpScoper0a6b37af0871\\App\\Controller\\AppController',
        'AppHelper' => '_PhpScoper0a6b37af0871\\App\\View\\Helper\\AppHelper',
        'AppModel' => '_PhpScoper0a6b37af0871\\App\\Model\\AppModel',
        'Cache' => '_PhpScoper0a6b37af0871\\Cake\\Cache\\Cache',
        'CakeEventListener' => '_PhpScoper0a6b37af0871\\Cake\\Event\\EventListener',
        'CakeLog' => '_PhpScoper0a6b37af0871\\Cake\\Log\\Log',
        'CakePlugin' => '_PhpScoper0a6b37af0871\\Cake\\Core\\Plugin',
        'CakeTestCase' => '_PhpScoper0a6b37af0871\\Cake\\TestSuite\\TestCase',
        'CakeTestFixture' => '_PhpScoper0a6b37af0871\\Cake\\TestSuite\\Fixture\\TestFixture',
        'Component' => '_PhpScoper0a6b37af0871\\Cake\\Controller\\Component',
        'ComponentRegistry' => '_PhpScoper0a6b37af0871\\Cake\\Controller\\ComponentRegistry',
        'Configure' => '_PhpScoper0a6b37af0871\\Cake\\Core\\Configure',
        'ConnectionManager' => '_PhpScoper0a6b37af0871\\Cake\\Database\\ConnectionManager',
        'Controller' => '_PhpScoper0a6b37af0871\\Cake\\Controller\\Controller',
        'Debugger' => '_PhpScoper0a6b37af0871\\Cake\\Error\\Debugger',
        'ExceptionRenderer' => '_PhpScoper0a6b37af0871\\Cake\\Error\\ExceptionRenderer',
        'Helper' => '_PhpScoper0a6b37af0871\\Cake\\View\\Helper',
        'HelperRegistry' => '_PhpScoper0a6b37af0871\\Cake\\View\\HelperRegistry',
        'Inflector' => '_PhpScoper0a6b37af0871\\Cake\\Utility\\Inflector',
        'Model' => '_PhpScoper0a6b37af0871\\Cake\\Model\\Model',
        'ModelBehavior' => '_PhpScoper0a6b37af0871\\Cake\\Model\\Behavior',
        'Object' => '_PhpScoper0a6b37af0871\\Cake\\Core\\Object',
        'Router' => '_PhpScoper0a6b37af0871\\Cake\\Routing\\Router',
        'Shell' => '_PhpScoper0a6b37af0871\\Cake\\Console\\Shell',
        'View' => '_PhpScoper0a6b37af0871\\Cake\\View\\View',
        // Also apply to already renamed ones
        'Log' => '_PhpScoper0a6b37af0871\\Cake\\Log\\Log',
        'Plugin' => '_PhpScoper0a6b37af0871\\Cake\\Core\\Plugin',
        'TestCase' => '_PhpScoper0a6b37af0871\\Cake\\TestSuite\\TestCase',
        'TestFixture' => '_PhpScoper0a6b37af0871\\Cake\\TestSuite\\Fixture\\TestFixture',
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
