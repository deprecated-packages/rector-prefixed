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
        'App' => '_PhpScoper26e51eeacccf\\Cake\\Core\\App',
        'AppController' => '_PhpScoper26e51eeacccf\\App\\Controller\\AppController',
        'AppHelper' => '_PhpScoper26e51eeacccf\\App\\View\\Helper\\AppHelper',
        'AppModel' => '_PhpScoper26e51eeacccf\\App\\Model\\AppModel',
        'Cache' => '_PhpScoper26e51eeacccf\\Cake\\Cache\\Cache',
        'CakeEventListener' => '_PhpScoper26e51eeacccf\\Cake\\Event\\EventListener',
        'CakeLog' => '_PhpScoper26e51eeacccf\\Cake\\Log\\Log',
        'CakePlugin' => '_PhpScoper26e51eeacccf\\Cake\\Core\\Plugin',
        'CakeTestCase' => '_PhpScoper26e51eeacccf\\Cake\\TestSuite\\TestCase',
        'CakeTestFixture' => '_PhpScoper26e51eeacccf\\Cake\\TestSuite\\Fixture\\TestFixture',
        'Component' => '_PhpScoper26e51eeacccf\\Cake\\Controller\\Component',
        'ComponentRegistry' => '_PhpScoper26e51eeacccf\\Cake\\Controller\\ComponentRegistry',
        'Configure' => '_PhpScoper26e51eeacccf\\Cake\\Core\\Configure',
        'ConnectionManager' => '_PhpScoper26e51eeacccf\\Cake\\Database\\ConnectionManager',
        'Controller' => '_PhpScoper26e51eeacccf\\Cake\\Controller\\Controller',
        'Debugger' => '_PhpScoper26e51eeacccf\\Cake\\Error\\Debugger',
        'ExceptionRenderer' => '_PhpScoper26e51eeacccf\\Cake\\Error\\ExceptionRenderer',
        'Helper' => '_PhpScoper26e51eeacccf\\Cake\\View\\Helper',
        'HelperRegistry' => '_PhpScoper26e51eeacccf\\Cake\\View\\HelperRegistry',
        'Inflector' => '_PhpScoper26e51eeacccf\\Cake\\Utility\\Inflector',
        'Model' => '_PhpScoper26e51eeacccf\\Cake\\Model\\Model',
        'ModelBehavior' => '_PhpScoper26e51eeacccf\\Cake\\Model\\Behavior',
        'Object' => '_PhpScoper26e51eeacccf\\Cake\\Core\\Object',
        'Router' => '_PhpScoper26e51eeacccf\\Cake\\Routing\\Router',
        'Shell' => '_PhpScoper26e51eeacccf\\Cake\\Console\\Shell',
        'View' => '_PhpScoper26e51eeacccf\\Cake\\View\\View',
        // Also apply to already renamed ones
        'Log' => '_PhpScoper26e51eeacccf\\Cake\\Log\\Log',
        'Plugin' => '_PhpScoper26e51eeacccf\\Cake\\Core\\Plugin',
        'TestCase' => '_PhpScoper26e51eeacccf\\Cake\\TestSuite\\TestCase',
        'TestFixture' => '_PhpScoper26e51eeacccf\\Cake\\TestSuite\\Fixture\\TestFixture',
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
