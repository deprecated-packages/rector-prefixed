<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa;

use _PhpScoper0a2ac50786fa\Rector\CakePHP\Rector\FileWithoutNamespace\ImplicitShortClassNameUseStatementRector;
use _PhpScoper0a2ac50786fa\Rector\CakePHP\Rector\Namespace_\AppUsesStaticCallToUseStatementRector;
use _PhpScoper0a2ac50786fa\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # @see https://github.com/cakephp/upgrade/tree/master/src/Shell/Task
    $services->set(\_PhpScoper0a2ac50786fa\Rector\CakePHP\Rector\Namespace_\AppUsesStaticCallToUseStatementRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\CakePHP\Rector\FileWithoutNamespace\ImplicitShortClassNameUseStatementRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoper0a2ac50786fa\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # see https://github.com/cakephp/upgrade/blob/756410c8b7d5aff9daec3fa1fe750a3858d422ac/src/Shell/Task/RenameClassesTask.php#L37
        '_PhpScoper0a2ac50786fa\\Cake\\Network\\Http\\HttpSocket' => '_PhpScoper0a2ac50786fa\\Cake\\Network\\Http\\Client',
        '_PhpScoper0a2ac50786fa\\Cake\\Model\\ConnectionManager' => '_PhpScoper0a2ac50786fa\\Cake\\Database\\ConnectionManager',
        '_PhpScoper0a2ac50786fa\\Cake\\TestSuite\\CakeTestCase' => '_PhpScoper0a2ac50786fa\\Cake\\TestSuite\\TestCase',
        '_PhpScoper0a2ac50786fa\\Cake\\TestSuite\\Fixture\\CakeTestFixture' => '_PhpScoper0a2ac50786fa\\Cake\\TestSuite\\Fixture\\TestFixture',
        '_PhpScoper0a2ac50786fa\\Cake\\Utility\\String' => '_PhpScoper0a2ac50786fa\\Cake\\Utility\\Text',
        'CakePlugin' => 'Plugin',
        'CakeException' => 'Exception',
        # see https://book.cakephp.org/3/en/appendices/3-0-migration-guide.html#configure
        '_PhpScoper0a2ac50786fa\\Cake\\Configure\\PhpReader' => '_PhpScoper0a2ac50786fa\\Cake\\Core\\Configure\\EnginePhpConfig',
        '_PhpScoper0a2ac50786fa\\Cake\\Configure\\IniReader' => '_PhpScoper0a2ac50786fa\\Cake\\Core\\Configure\\EngineIniConfig',
        '_PhpScoper0a2ac50786fa\\Cake\\Configure\\ConfigReaderInterface' => '_PhpScoper0a2ac50786fa\\Cake\\Core\\Configure\\ConfigEngineInterface',
        # https://book.cakephp.org/3/en/appendices/3-0-migration-guide.html#request
        'CakeRequest' => '_PhpScoper0a2ac50786fa\\Cake\\Network\\Request',
    ]]]);
};
