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
        'App' => 'RectorPrefix20210320\\Cake\\Core\\App',
        'AppController' => 'RectorPrefix20210320\\App\\Controller\\AppController',
        'AppHelper' => 'RectorPrefix20210320\\App\\View\\Helper\\AppHelper',
        'AppModel' => 'RectorPrefix20210320\\App\\Model\\AppModel',
        'Cache' => 'RectorPrefix20210320\\Cake\\Cache\\Cache',
        'CakeEventListener' => 'RectorPrefix20210320\\Cake\\Event\\EventListener',
        'CakeLog' => 'RectorPrefix20210320\\Cake\\Log\\Log',
        'CakePlugin' => 'RectorPrefix20210320\\Cake\\Core\\Plugin',
        'CakeTestCase' => 'RectorPrefix20210320\\Cake\\TestSuite\\TestCase',
        'CakeTestFixture' => 'RectorPrefix20210320\\Cake\\TestSuite\\Fixture\\TestFixture',
        'Component' => 'RectorPrefix20210320\\Cake\\Controller\\Component',
        'ComponentRegistry' => 'RectorPrefix20210320\\Cake\\Controller\\ComponentRegistry',
        'Configure' => 'RectorPrefix20210320\\Cake\\Core\\Configure',
        'ConnectionManager' => 'RectorPrefix20210320\\Cake\\Database\\ConnectionManager',
        'Controller' => 'RectorPrefix20210320\\Cake\\Controller\\Controller',
        'Debugger' => 'RectorPrefix20210320\\Cake\\Error\\Debugger',
        'ExceptionRenderer' => 'RectorPrefix20210320\\Cake\\Error\\ExceptionRenderer',
        'Helper' => 'RectorPrefix20210320\\Cake\\View\\Helper',
        'HelperRegistry' => 'RectorPrefix20210320\\Cake\\View\\HelperRegistry',
        'Inflector' => 'RectorPrefix20210320\\Cake\\Utility\\Inflector',
        'Model' => 'RectorPrefix20210320\\Cake\\Model\\Model',
        'ModelBehavior' => 'RectorPrefix20210320\\Cake\\Model\\Behavior',
        'Object' => 'RectorPrefix20210320\\Cake\\Core\\Object',
        'Router' => 'RectorPrefix20210320\\Cake\\Routing\\Router',
        'Shell' => 'RectorPrefix20210320\\Cake\\Console\\Shell',
        'View' => 'RectorPrefix20210320\\Cake\\View\\View',
        // Also apply to already renamed ones
        'Log' => 'RectorPrefix20210320\\Cake\\Log\\Log',
        'Plugin' => 'RectorPrefix20210320\\Cake\\Core\\Plugin',
        'TestCase' => 'RectorPrefix20210320\\Cake\\TestSuite\\TestCase',
        'TestFixture' => 'RectorPrefix20210320\\Cake\\TestSuite\\Fixture\\TestFixture',
    ];
    /**
     * This value used to be directory So "/" in path should be "\" in namespace
     */
    public function resolve(string $shortClass) : ?string
    {
        return self::IMPLICIT_MAP[$shortClass] ?? null;
    }
}
