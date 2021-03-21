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
        'App' => 'RectorPrefix20210321\\Cake\\Core\\App',
        'AppController' => 'RectorPrefix20210321\\App\\Controller\\AppController',
        'AppHelper' => 'RectorPrefix20210321\\App\\View\\Helper\\AppHelper',
        'AppModel' => 'RectorPrefix20210321\\App\\Model\\AppModel',
        'Cache' => 'RectorPrefix20210321\\Cake\\Cache\\Cache',
        'CakeEventListener' => 'RectorPrefix20210321\\Cake\\Event\\EventListener',
        'CakeLog' => 'RectorPrefix20210321\\Cake\\Log\\Log',
        'CakePlugin' => 'RectorPrefix20210321\\Cake\\Core\\Plugin',
        'CakeTestCase' => 'RectorPrefix20210321\\Cake\\TestSuite\\TestCase',
        'CakeTestFixture' => 'RectorPrefix20210321\\Cake\\TestSuite\\Fixture\\TestFixture',
        'Component' => 'RectorPrefix20210321\\Cake\\Controller\\Component',
        'ComponentRegistry' => 'RectorPrefix20210321\\Cake\\Controller\\ComponentRegistry',
        'Configure' => 'RectorPrefix20210321\\Cake\\Core\\Configure',
        'ConnectionManager' => 'RectorPrefix20210321\\Cake\\Database\\ConnectionManager',
        'Controller' => 'RectorPrefix20210321\\Cake\\Controller\\Controller',
        'Debugger' => 'RectorPrefix20210321\\Cake\\Error\\Debugger',
        'ExceptionRenderer' => 'RectorPrefix20210321\\Cake\\Error\\ExceptionRenderer',
        'Helper' => 'RectorPrefix20210321\\Cake\\View\\Helper',
        'HelperRegistry' => 'RectorPrefix20210321\\Cake\\View\\HelperRegistry',
        'Inflector' => 'RectorPrefix20210321\\Cake\\Utility\\Inflector',
        'Model' => 'RectorPrefix20210321\\Cake\\Model\\Model',
        'ModelBehavior' => 'RectorPrefix20210321\\Cake\\Model\\Behavior',
        'Object' => 'RectorPrefix20210321\\Cake\\Core\\Object',
        'Router' => 'RectorPrefix20210321\\Cake\\Routing\\Router',
        'Shell' => 'RectorPrefix20210321\\Cake\\Console\\Shell',
        'View' => 'RectorPrefix20210321\\Cake\\View\\View',
        // Also apply to already renamed ones
        'Log' => 'RectorPrefix20210321\\Cake\\Log\\Log',
        'Plugin' => 'RectorPrefix20210321\\Cake\\Core\\Plugin',
        'TestCase' => 'RectorPrefix20210321\\Cake\\TestSuite\\TestCase',
        'TestFixture' => 'RectorPrefix20210321\\Cake\\TestSuite\\Fixture\\TestFixture',
    ];
    /**
     * This value used to be directory So "/" in path should be "\" in namespace
     */
    public function resolve(string $shortClass) : ?string
    {
        return self::IMPLICIT_MAP[$shortClass] ?? null;
    }
}
