<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CakePHP;

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
        'App' => '_PhpScoperb75b35f52b74\\Cake\\Core\\App',
        'AppController' => '_PhpScoperb75b35f52b74\\App\\Controller\\AppController',
        'AppHelper' => '_PhpScoperb75b35f52b74\\App\\View\\Helper\\AppHelper',
        'AppModel' => '_PhpScoperb75b35f52b74\\App\\Model\\AppModel',
        'Cache' => '_PhpScoperb75b35f52b74\\Cake\\Cache\\Cache',
        'CakeEventListener' => '_PhpScoperb75b35f52b74\\Cake\\Event\\EventListener',
        'CakeLog' => '_PhpScoperb75b35f52b74\\Cake\\Log\\Log',
        'CakePlugin' => '_PhpScoperb75b35f52b74\\Cake\\Core\\Plugin',
        'CakeTestCase' => '_PhpScoperb75b35f52b74\\Cake\\TestSuite\\TestCase',
        'CakeTestFixture' => '_PhpScoperb75b35f52b74\\Cake\\TestSuite\\Fixture\\TestFixture',
        'Component' => '_PhpScoperb75b35f52b74\\Cake\\Controller\\Component',
        'ComponentRegistry' => '_PhpScoperb75b35f52b74\\Cake\\Controller\\ComponentRegistry',
        'Configure' => '_PhpScoperb75b35f52b74\\Cake\\Core\\Configure',
        'ConnectionManager' => '_PhpScoperb75b35f52b74\\Cake\\Database\\ConnectionManager',
        'Controller' => '_PhpScoperb75b35f52b74\\Cake\\Controller\\Controller',
        'Debugger' => '_PhpScoperb75b35f52b74\\Cake\\Error\\Debugger',
        'ExceptionRenderer' => '_PhpScoperb75b35f52b74\\Cake\\Error\\ExceptionRenderer',
        'Helper' => '_PhpScoperb75b35f52b74\\Cake\\View\\Helper',
        'HelperRegistry' => '_PhpScoperb75b35f52b74\\Cake\\View\\HelperRegistry',
        'Inflector' => '_PhpScoperb75b35f52b74\\Cake\\Utility\\Inflector',
        'Model' => '_PhpScoperb75b35f52b74\\Cake\\Model\\Model',
        'ModelBehavior' => '_PhpScoperb75b35f52b74\\Cake\\Model\\Behavior',
        'Object' => '_PhpScoperb75b35f52b74\\Cake\\Core\\Object',
        'Router' => '_PhpScoperb75b35f52b74\\Cake\\Routing\\Router',
        'Shell' => '_PhpScoperb75b35f52b74\\Cake\\Console\\Shell',
        'View' => '_PhpScoperb75b35f52b74\\Cake\\View\\View',
        // Also apply to already renamed ones
        'Log' => '_PhpScoperb75b35f52b74\\Cake\\Log\\Log',
        'Plugin' => '_PhpScoperb75b35f52b74\\Cake\\Core\\Plugin',
        'TestCase' => '_PhpScoperb75b35f52b74\\Cake\\TestSuite\\TestCase',
        'TestFixture' => '_PhpScoperb75b35f52b74\\Cake\\TestSuite\\Fixture\\TestFixture',
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
