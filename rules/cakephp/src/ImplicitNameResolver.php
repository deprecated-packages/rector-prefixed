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
        'App' => '_PhpScoper50d83356d739\\Cake\\Core\\App',
        'AppController' => '_PhpScoper50d83356d739\\App\\Controller\\AppController',
        'AppHelper' => '_PhpScoper50d83356d739\\App\\View\\Helper\\AppHelper',
        'AppModel' => '_PhpScoper50d83356d739\\App\\Model\\AppModel',
        'Cache' => '_PhpScoper50d83356d739\\Cake\\Cache\\Cache',
        'CakeEventListener' => '_PhpScoper50d83356d739\\Cake\\Event\\EventListener',
        'CakeLog' => '_PhpScoper50d83356d739\\Cake\\Log\\Log',
        'CakePlugin' => '_PhpScoper50d83356d739\\Cake\\Core\\Plugin',
        'CakeTestCase' => '_PhpScoper50d83356d739\\Cake\\TestSuite\\TestCase',
        'CakeTestFixture' => '_PhpScoper50d83356d739\\Cake\\TestSuite\\Fixture\\TestFixture',
        'Component' => '_PhpScoper50d83356d739\\Cake\\Controller\\Component',
        'ComponentRegistry' => '_PhpScoper50d83356d739\\Cake\\Controller\\ComponentRegistry',
        'Configure' => '_PhpScoper50d83356d739\\Cake\\Core\\Configure',
        'ConnectionManager' => '_PhpScoper50d83356d739\\Cake\\Database\\ConnectionManager',
        'Controller' => '_PhpScoper50d83356d739\\Cake\\Controller\\Controller',
        'Debugger' => '_PhpScoper50d83356d739\\Cake\\Error\\Debugger',
        'ExceptionRenderer' => '_PhpScoper50d83356d739\\Cake\\Error\\ExceptionRenderer',
        'Helper' => '_PhpScoper50d83356d739\\Cake\\View\\Helper',
        'HelperRegistry' => '_PhpScoper50d83356d739\\Cake\\View\\HelperRegistry',
        'Inflector' => '_PhpScoper50d83356d739\\Cake\\Utility\\Inflector',
        'Model' => '_PhpScoper50d83356d739\\Cake\\Model\\Model',
        'ModelBehavior' => '_PhpScoper50d83356d739\\Cake\\Model\\Behavior',
        'Object' => '_PhpScoper50d83356d739\\Cake\\Core\\Object',
        'Router' => '_PhpScoper50d83356d739\\Cake\\Routing\\Router',
        'Shell' => '_PhpScoper50d83356d739\\Cake\\Console\\Shell',
        'View' => '_PhpScoper50d83356d739\\Cake\\View\\View',
        // Also apply to already renamed ones
        'Log' => '_PhpScoper50d83356d739\\Cake\\Log\\Log',
        'Plugin' => '_PhpScoper50d83356d739\\Cake\\Core\\Plugin',
        'TestCase' => '_PhpScoper50d83356d739\\Cake\\TestSuite\\TestCase',
        'TestFixture' => '_PhpScoper50d83356d739\\Cake\\TestSuite\\Fixture\\TestFixture',
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
