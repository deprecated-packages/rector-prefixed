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
        'App' => 'RectorPrefix20201228\\Cake\\Core\\App',
        'AppController' => 'RectorPrefix20201228\\App\\Controller\\AppController',
        'AppHelper' => 'RectorPrefix20201228\\App\\View\\Helper\\AppHelper',
        'AppModel' => 'RectorPrefix20201228\\App\\Model\\AppModel',
        'Cache' => 'RectorPrefix20201228\\Cake\\Cache\\Cache',
        'CakeEventListener' => 'RectorPrefix20201228\\Cake\\Event\\EventListener',
        'CakeLog' => 'RectorPrefix20201228\\Cake\\Log\\Log',
        'CakePlugin' => 'RectorPrefix20201228\\Cake\\Core\\Plugin',
        'CakeTestCase' => 'RectorPrefix20201228\\Cake\\TestSuite\\TestCase',
        'CakeTestFixture' => 'RectorPrefix20201228\\Cake\\TestSuite\\Fixture\\TestFixture',
        'Component' => 'RectorPrefix20201228\\Cake\\Controller\\Component',
        'ComponentRegistry' => 'RectorPrefix20201228\\Cake\\Controller\\ComponentRegistry',
        'Configure' => 'RectorPrefix20201228\\Cake\\Core\\Configure',
        'ConnectionManager' => 'RectorPrefix20201228\\Cake\\Database\\ConnectionManager',
        'Controller' => 'RectorPrefix20201228\\Cake\\Controller\\Controller',
        'Debugger' => 'RectorPrefix20201228\\Cake\\Error\\Debugger',
        'ExceptionRenderer' => 'RectorPrefix20201228\\Cake\\Error\\ExceptionRenderer',
        'Helper' => 'RectorPrefix20201228\\Cake\\View\\Helper',
        'HelperRegistry' => 'RectorPrefix20201228\\Cake\\View\\HelperRegistry',
        'Inflector' => 'RectorPrefix20201228\\Cake\\Utility\\Inflector',
        'Model' => 'RectorPrefix20201228\\Cake\\Model\\Model',
        'ModelBehavior' => 'RectorPrefix20201228\\Cake\\Model\\Behavior',
        'Object' => 'RectorPrefix20201228\\Cake\\Core\\Object',
        'Router' => 'RectorPrefix20201228\\Cake\\Routing\\Router',
        'Shell' => 'RectorPrefix20201228\\Cake\\Console\\Shell',
        'View' => 'RectorPrefix20201228\\Cake\\View\\View',
        // Also apply to already renamed ones
        'Log' => 'RectorPrefix20201228\\Cake\\Log\\Log',
        'Plugin' => 'RectorPrefix20201228\\Cake\\Core\\Plugin',
        'TestCase' => 'RectorPrefix20201228\\Cake\\TestSuite\\TestCase',
        'TestFixture' => 'RectorPrefix20201228\\Cake\\TestSuite\\Fixture\\TestFixture',
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
