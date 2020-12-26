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
        'App' => 'RectorPrefix2020DecSat\\Cake\\Core\\App',
        'AppController' => 'RectorPrefix2020DecSat\\App\\Controller\\AppController',
        'AppHelper' => 'RectorPrefix2020DecSat\\App\\View\\Helper\\AppHelper',
        'AppModel' => 'RectorPrefix2020DecSat\\App\\Model\\AppModel',
        'Cache' => 'RectorPrefix2020DecSat\\Cake\\Cache\\Cache',
        'CakeEventListener' => 'RectorPrefix2020DecSat\\Cake\\Event\\EventListener',
        'CakeLog' => 'RectorPrefix2020DecSat\\Cake\\Log\\Log',
        'CakePlugin' => 'RectorPrefix2020DecSat\\Cake\\Core\\Plugin',
        'CakeTestCase' => 'RectorPrefix2020DecSat\\Cake\\TestSuite\\TestCase',
        'CakeTestFixture' => 'RectorPrefix2020DecSat\\Cake\\TestSuite\\Fixture\\TestFixture',
        'Component' => 'RectorPrefix2020DecSat\\Cake\\Controller\\Component',
        'ComponentRegistry' => 'RectorPrefix2020DecSat\\Cake\\Controller\\ComponentRegistry',
        'Configure' => 'RectorPrefix2020DecSat\\Cake\\Core\\Configure',
        'ConnectionManager' => 'RectorPrefix2020DecSat\\Cake\\Database\\ConnectionManager',
        'Controller' => 'RectorPrefix2020DecSat\\Cake\\Controller\\Controller',
        'Debugger' => 'RectorPrefix2020DecSat\\Cake\\Error\\Debugger',
        'ExceptionRenderer' => 'RectorPrefix2020DecSat\\Cake\\Error\\ExceptionRenderer',
        'Helper' => 'RectorPrefix2020DecSat\\Cake\\View\\Helper',
        'HelperRegistry' => 'RectorPrefix2020DecSat\\Cake\\View\\HelperRegistry',
        'Inflector' => 'RectorPrefix2020DecSat\\Cake\\Utility\\Inflector',
        'Model' => 'RectorPrefix2020DecSat\\Cake\\Model\\Model',
        'ModelBehavior' => 'RectorPrefix2020DecSat\\Cake\\Model\\Behavior',
        'Object' => 'RectorPrefix2020DecSat\\Cake\\Core\\Object',
        'Router' => 'RectorPrefix2020DecSat\\Cake\\Routing\\Router',
        'Shell' => 'RectorPrefix2020DecSat\\Cake\\Console\\Shell',
        'View' => 'RectorPrefix2020DecSat\\Cake\\View\\View',
        // Also apply to already renamed ones
        'Log' => 'RectorPrefix2020DecSat\\Cake\\Log\\Log',
        'Plugin' => 'RectorPrefix2020DecSat\\Cake\\Core\\Plugin',
        'TestCase' => 'RectorPrefix2020DecSat\\Cake\\TestSuite\\TestCase',
        'TestFixture' => 'RectorPrefix2020DecSat\\Cake\\TestSuite\\Fixture\\TestFixture',
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
