<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\CakePHP\Rector\FileWithoutNamespace\ImplicitShortClassNameUseStatementRector;
use _PhpScoper0a6b37af0871\Rector\CakePHP\Rector\Namespace_\AppUsesStaticCallToUseStatementRector;
use _PhpScoper0a6b37af0871\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # @see https://github.com/cakephp/upgrade/tree/master/src/Shell/Task
    $services->set(\_PhpScoper0a6b37af0871\Rector\CakePHP\Rector\Namespace_\AppUsesStaticCallToUseStatementRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\CakePHP\Rector\FileWithoutNamespace\ImplicitShortClassNameUseStatementRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # see https://github.com/cakephp/upgrade/blob/756410c8b7d5aff9daec3fa1fe750a3858d422ac/src/Shell/Task/RenameClassesTask.php#L37
        '_PhpScoper0a6b37af0871\\Cake\\Network\\Http\\HttpSocket' => '_PhpScoper0a6b37af0871\\Cake\\Network\\Http\\Client',
        '_PhpScoper0a6b37af0871\\Cake\\Model\\ConnectionManager' => '_PhpScoper0a6b37af0871\\Cake\\Database\\ConnectionManager',
        '_PhpScoper0a6b37af0871\\Cake\\TestSuite\\CakeTestCase' => '_PhpScoper0a6b37af0871\\Cake\\TestSuite\\TestCase',
        '_PhpScoper0a6b37af0871\\Cake\\TestSuite\\Fixture\\CakeTestFixture' => '_PhpScoper0a6b37af0871\\Cake\\TestSuite\\Fixture\\TestFixture',
        '_PhpScoper0a6b37af0871\\Cake\\Utility\\String' => '_PhpScoper0a6b37af0871\\Cake\\Utility\\Text',
        'CakePlugin' => 'Plugin',
        'CakeException' => 'Exception',
        # see https://book.cakephp.org/3/en/appendices/3-0-migration-guide.html#configure
        '_PhpScoper0a6b37af0871\\Cake\\Configure\\PhpReader' => '_PhpScoper0a6b37af0871\\Cake\\Core\\Configure\\EnginePhpConfig',
        '_PhpScoper0a6b37af0871\\Cake\\Configure\\IniReader' => '_PhpScoper0a6b37af0871\\Cake\\Core\\Configure\\EngineIniConfig',
        '_PhpScoper0a6b37af0871\\Cake\\Configure\\ConfigReaderInterface' => '_PhpScoper0a6b37af0871\\Cake\\Core\\Configure\\ConfigEngineInterface',
        # https://book.cakephp.org/3/en/appendices/3-0-migration-guide.html#request
        'CakeRequest' => '_PhpScoper0a6b37af0871\\Cake\\Network\\Request',
    ]]]);
};
