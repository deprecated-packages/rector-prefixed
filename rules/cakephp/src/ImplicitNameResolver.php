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
        'App' => 'RectorPrefix20201227\\Cake\\Core\\App',
        'AppController' => 'RectorPrefix20201227\\App\\Controller\\AppController',
        'AppHelper' => 'RectorPrefix20201227\\App\\View\\Helper\\AppHelper',
        'AppModel' => 'RectorPrefix20201227\\App\\Model\\AppModel',
        'Cache' => 'RectorPrefix20201227\\Cake\\Cache\\Cache',
        'CakeEventListener' => 'RectorPrefix20201227\\Cake\\Event\\EventListener',
        'CakeLog' => 'RectorPrefix20201227\\Cake\\Log\\Log',
        'CakePlugin' => 'RectorPrefix20201227\\Cake\\Core\\Plugin',
        'CakeTestCase' => 'RectorPrefix20201227\\Cake\\TestSuite\\TestCase',
        'CakeTestFixture' => 'RectorPrefix20201227\\Cake\\TestSuite\\Fixture\\TestFixture',
        'Component' => 'RectorPrefix20201227\\Cake\\Controller\\Component',
        'ComponentRegistry' => 'RectorPrefix20201227\\Cake\\Controller\\ComponentRegistry',
        'Configure' => 'RectorPrefix20201227\\Cake\\Core\\Configure',
        'ConnectionManager' => 'RectorPrefix20201227\\Cake\\Database\\ConnectionManager',
        'Controller' => 'RectorPrefix20201227\\Cake\\Controller\\Controller',
        'Debugger' => 'RectorPrefix20201227\\Cake\\Error\\Debugger',
        'ExceptionRenderer' => 'RectorPrefix20201227\\Cake\\Error\\ExceptionRenderer',
        'Helper' => 'RectorPrefix20201227\\Cake\\View\\Helper',
        'HelperRegistry' => 'RectorPrefix20201227\\Cake\\View\\HelperRegistry',
        'Inflector' => 'RectorPrefix20201227\\Cake\\Utility\\Inflector',
        'Model' => 'RectorPrefix20201227\\Cake\\Model\\Model',
        'ModelBehavior' => 'RectorPrefix20201227\\Cake\\Model\\Behavior',
        'Object' => 'RectorPrefix20201227\\Cake\\Core\\Object',
        'Router' => 'RectorPrefix20201227\\Cake\\Routing\\Router',
        'Shell' => 'RectorPrefix20201227\\Cake\\Console\\Shell',
        'View' => 'RectorPrefix20201227\\Cake\\View\\View',
        // Also apply to already renamed ones
        'Log' => 'RectorPrefix20201227\\Cake\\Log\\Log',
        'Plugin' => 'RectorPrefix20201227\\Cake\\Core\\Plugin',
        'TestCase' => 'RectorPrefix20201227\\Cake\\TestSuite\\TestCase',
        'TestFixture' => 'RectorPrefix20201227\\Cake\\TestSuite\\Fixture\\TestFixture',
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
