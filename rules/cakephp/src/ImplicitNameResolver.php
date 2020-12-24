<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CakePHP;

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
        'App' => '_PhpScopere8e811afab72\\Cake\\Core\\App',
        'AppController' => '_PhpScopere8e811afab72\\App\\Controller\\AppController',
        'AppHelper' => '_PhpScopere8e811afab72\\App\\View\\Helper\\AppHelper',
        'AppModel' => '_PhpScopere8e811afab72\\App\\Model\\AppModel',
        'Cache' => '_PhpScopere8e811afab72\\Cake\\Cache\\Cache',
        'CakeEventListener' => '_PhpScopere8e811afab72\\Cake\\Event\\EventListener',
        'CakeLog' => '_PhpScopere8e811afab72\\Cake\\Log\\Log',
        'CakePlugin' => '_PhpScopere8e811afab72\\Cake\\Core\\Plugin',
        'CakeTestCase' => '_PhpScopere8e811afab72\\Cake\\TestSuite\\TestCase',
        'CakeTestFixture' => '_PhpScopere8e811afab72\\Cake\\TestSuite\\Fixture\\TestFixture',
        'Component' => '_PhpScopere8e811afab72\\Cake\\Controller\\Component',
        'ComponentRegistry' => '_PhpScopere8e811afab72\\Cake\\Controller\\ComponentRegistry',
        'Configure' => '_PhpScopere8e811afab72\\Cake\\Core\\Configure',
        'ConnectionManager' => '_PhpScopere8e811afab72\\Cake\\Database\\ConnectionManager',
        'Controller' => '_PhpScopere8e811afab72\\Cake\\Controller\\Controller',
        'Debugger' => '_PhpScopere8e811afab72\\Cake\\Error\\Debugger',
        'ExceptionRenderer' => '_PhpScopere8e811afab72\\Cake\\Error\\ExceptionRenderer',
        'Helper' => '_PhpScopere8e811afab72\\Cake\\View\\Helper',
        'HelperRegistry' => '_PhpScopere8e811afab72\\Cake\\View\\HelperRegistry',
        'Inflector' => '_PhpScopere8e811afab72\\Cake\\Utility\\Inflector',
        'Model' => '_PhpScopere8e811afab72\\Cake\\Model\\Model',
        'ModelBehavior' => '_PhpScopere8e811afab72\\Cake\\Model\\Behavior',
        'Object' => '_PhpScopere8e811afab72\\Cake\\Core\\Object',
        'Router' => '_PhpScopere8e811afab72\\Cake\\Routing\\Router',
        'Shell' => '_PhpScopere8e811afab72\\Cake\\Console\\Shell',
        'View' => '_PhpScopere8e811afab72\\Cake\\View\\View',
        // Also apply to already renamed ones
        'Log' => '_PhpScopere8e811afab72\\Cake\\Log\\Log',
        'Plugin' => '_PhpScopere8e811afab72\\Cake\\Core\\Plugin',
        'TestCase' => '_PhpScopere8e811afab72\\Cake\\TestSuite\\TestCase',
        'TestFixture' => '_PhpScopere8e811afab72\\Cake\\TestSuite\\Fixture\\TestFixture',
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
