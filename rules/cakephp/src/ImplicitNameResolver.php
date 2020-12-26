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
        'App' => 'RectorPrefix20201226\\Cake\\Core\\App',
        'AppController' => 'RectorPrefix20201226\\App\\Controller\\AppController',
        'AppHelper' => 'RectorPrefix20201226\\App\\View\\Helper\\AppHelper',
        'AppModel' => 'RectorPrefix20201226\\App\\Model\\AppModel',
        'Cache' => 'RectorPrefix20201226\\Cake\\Cache\\Cache',
        'CakeEventListener' => 'RectorPrefix20201226\\Cake\\Event\\EventListener',
        'CakeLog' => 'RectorPrefix20201226\\Cake\\Log\\Log',
        'CakePlugin' => 'RectorPrefix20201226\\Cake\\Core\\Plugin',
        'CakeTestCase' => 'RectorPrefix20201226\\Cake\\TestSuite\\TestCase',
        'CakeTestFixture' => 'RectorPrefix20201226\\Cake\\TestSuite\\Fixture\\TestFixture',
        'Component' => 'RectorPrefix20201226\\Cake\\Controller\\Component',
        'ComponentRegistry' => 'RectorPrefix20201226\\Cake\\Controller\\ComponentRegistry',
        'Configure' => 'RectorPrefix20201226\\Cake\\Core\\Configure',
        'ConnectionManager' => 'RectorPrefix20201226\\Cake\\Database\\ConnectionManager',
        'Controller' => 'RectorPrefix20201226\\Cake\\Controller\\Controller',
        'Debugger' => 'RectorPrefix20201226\\Cake\\Error\\Debugger',
        'ExceptionRenderer' => 'RectorPrefix20201226\\Cake\\Error\\ExceptionRenderer',
        'Helper' => 'RectorPrefix20201226\\Cake\\View\\Helper',
        'HelperRegistry' => 'RectorPrefix20201226\\Cake\\View\\HelperRegistry',
        'Inflector' => 'RectorPrefix20201226\\Cake\\Utility\\Inflector',
        'Model' => 'RectorPrefix20201226\\Cake\\Model\\Model',
        'ModelBehavior' => 'RectorPrefix20201226\\Cake\\Model\\Behavior',
        'Object' => 'RectorPrefix20201226\\Cake\\Core\\Object',
        'Router' => 'RectorPrefix20201226\\Cake\\Routing\\Router',
        'Shell' => 'RectorPrefix20201226\\Cake\\Console\\Shell',
        'View' => 'RectorPrefix20201226\\Cake\\View\\View',
        // Also apply to already renamed ones
        'Log' => 'RectorPrefix20201226\\Cake\\Log\\Log',
        'Plugin' => 'RectorPrefix20201226\\Cake\\Core\\Plugin',
        'TestCase' => 'RectorPrefix20201226\\Cake\\TestSuite\\TestCase',
        'TestFixture' => 'RectorPrefix20201226\\Cake\\TestSuite\\Fixture\\TestFixture',
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
