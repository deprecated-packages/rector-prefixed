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
        'App' => '_PhpScoperbd5d0c5f7638\\Cake\\Core\\App',
        'AppController' => '_PhpScoperbd5d0c5f7638\\App\\Controller\\AppController',
        'AppHelper' => '_PhpScoperbd5d0c5f7638\\App\\View\\Helper\\AppHelper',
        'AppModel' => '_PhpScoperbd5d0c5f7638\\App\\Model\\AppModel',
        'Cache' => '_PhpScoperbd5d0c5f7638\\Cake\\Cache\\Cache',
        'CakeEventListener' => '_PhpScoperbd5d0c5f7638\\Cake\\Event\\EventListener',
        'CakeLog' => '_PhpScoperbd5d0c5f7638\\Cake\\Log\\Log',
        'CakePlugin' => '_PhpScoperbd5d0c5f7638\\Cake\\Core\\Plugin',
        'CakeTestCase' => '_PhpScoperbd5d0c5f7638\\Cake\\TestSuite\\TestCase',
        'CakeTestFixture' => '_PhpScoperbd5d0c5f7638\\Cake\\TestSuite\\Fixture\\TestFixture',
        'Component' => '_PhpScoperbd5d0c5f7638\\Cake\\Controller\\Component',
        'ComponentRegistry' => '_PhpScoperbd5d0c5f7638\\Cake\\Controller\\ComponentRegistry',
        'Configure' => '_PhpScoperbd5d0c5f7638\\Cake\\Core\\Configure',
        'ConnectionManager' => '_PhpScoperbd5d0c5f7638\\Cake\\Database\\ConnectionManager',
        'Controller' => '_PhpScoperbd5d0c5f7638\\Cake\\Controller\\Controller',
        'Debugger' => '_PhpScoperbd5d0c5f7638\\Cake\\Error\\Debugger',
        'ExceptionRenderer' => '_PhpScoperbd5d0c5f7638\\Cake\\Error\\ExceptionRenderer',
        'Helper' => '_PhpScoperbd5d0c5f7638\\Cake\\View\\Helper',
        'HelperRegistry' => '_PhpScoperbd5d0c5f7638\\Cake\\View\\HelperRegistry',
        'Inflector' => '_PhpScoperbd5d0c5f7638\\Cake\\Utility\\Inflector',
        'Model' => '_PhpScoperbd5d0c5f7638\\Cake\\Model\\Model',
        'ModelBehavior' => '_PhpScoperbd5d0c5f7638\\Cake\\Model\\Behavior',
        'Object' => '_PhpScoperbd5d0c5f7638\\Cake\\Core\\Object',
        'Router' => '_PhpScoperbd5d0c5f7638\\Cake\\Routing\\Router',
        'Shell' => '_PhpScoperbd5d0c5f7638\\Cake\\Console\\Shell',
        'View' => '_PhpScoperbd5d0c5f7638\\Cake\\View\\View',
        // Also apply to already renamed ones
        'Log' => '_PhpScoperbd5d0c5f7638\\Cake\\Log\\Log',
        'Plugin' => '_PhpScoperbd5d0c5f7638\\Cake\\Core\\Plugin',
        'TestCase' => '_PhpScoperbd5d0c5f7638\\Cake\\TestSuite\\TestCase',
        'TestFixture' => '_PhpScoperbd5d0c5f7638\\Cake\\TestSuite\\Fixture\\TestFixture',
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
