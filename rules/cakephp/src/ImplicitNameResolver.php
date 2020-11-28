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
        'App' => '_PhpScoperabd03f0baf05\\Cake\\Core\\App',
        'AppController' => '_PhpScoperabd03f0baf05\\App\\Controller\\AppController',
        'AppHelper' => '_PhpScoperabd03f0baf05\\App\\View\\Helper\\AppHelper',
        'AppModel' => '_PhpScoperabd03f0baf05\\App\\Model\\AppModel',
        'Cache' => '_PhpScoperabd03f0baf05\\Cake\\Cache\\Cache',
        'CakeEventListener' => '_PhpScoperabd03f0baf05\\Cake\\Event\\EventListener',
        'CakeLog' => '_PhpScoperabd03f0baf05\\Cake\\Log\\Log',
        'CakePlugin' => '_PhpScoperabd03f0baf05\\Cake\\Core\\Plugin',
        'CakeTestCase' => '_PhpScoperabd03f0baf05\\Cake\\TestSuite\\TestCase',
        'CakeTestFixture' => '_PhpScoperabd03f0baf05\\Cake\\TestSuite\\Fixture\\TestFixture',
        'Component' => '_PhpScoperabd03f0baf05\\Cake\\Controller\\Component',
        'ComponentRegistry' => '_PhpScoperabd03f0baf05\\Cake\\Controller\\ComponentRegistry',
        'Configure' => '_PhpScoperabd03f0baf05\\Cake\\Core\\Configure',
        'ConnectionManager' => '_PhpScoperabd03f0baf05\\Cake\\Database\\ConnectionManager',
        'Controller' => '_PhpScoperabd03f0baf05\\Cake\\Controller\\Controller',
        'Debugger' => '_PhpScoperabd03f0baf05\\Cake\\Error\\Debugger',
        'ExceptionRenderer' => '_PhpScoperabd03f0baf05\\Cake\\Error\\ExceptionRenderer',
        'Helper' => '_PhpScoperabd03f0baf05\\Cake\\View\\Helper',
        'HelperRegistry' => '_PhpScoperabd03f0baf05\\Cake\\View\\HelperRegistry',
        'Inflector' => '_PhpScoperabd03f0baf05\\Cake\\Utility\\Inflector',
        'Model' => '_PhpScoperabd03f0baf05\\Cake\\Model\\Model',
        'ModelBehavior' => '_PhpScoperabd03f0baf05\\Cake\\Model\\Behavior',
        'Object' => '_PhpScoperabd03f0baf05\\Cake\\Core\\Object',
        'Router' => '_PhpScoperabd03f0baf05\\Cake\\Routing\\Router',
        'Shell' => '_PhpScoperabd03f0baf05\\Cake\\Console\\Shell',
        'View' => '_PhpScoperabd03f0baf05\\Cake\\View\\View',
        // Also apply to already renamed ones
        'Log' => '_PhpScoperabd03f0baf05\\Cake\\Log\\Log',
        'Plugin' => '_PhpScoperabd03f0baf05\\Cake\\Core\\Plugin',
        'TestCase' => '_PhpScoperabd03f0baf05\\Cake\\TestSuite\\TestCase',
        'TestFixture' => '_PhpScoperabd03f0baf05\\Cake\\TestSuite\\Fixture\\TestFixture',
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
