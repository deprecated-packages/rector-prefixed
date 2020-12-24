<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\Stubs;

use _PhpScoper0a6b37af0871\Nette\Loaders\RobotLoader;
final class StubLoader
{
    /**
     * @var bool
     */
    private $areStubsLoaded = \false;
    /**
     * Load stubs after composer autoload is loaded + rector "process <src>" is loaded,
     * so it is loaded only if the classes are really missing
     */
    public function loadStubs() : void
    {
        if ($this->areStubsLoaded) {
            return;
        }
        $stubDirectory = __DIR__ . '/../../stubs';
        // stubs might not exists on composer install, to prevent PHPStorm duplicated confusion
        // @see https://github.com/rectorphp/rector/issues/1899
        if (!\file_exists($stubDirectory)) {
            return;
        }
        $robotLoader = new \_PhpScoper0a6b37af0871\Nette\Loaders\RobotLoader();
        $robotLoader->addDirectory($stubDirectory);
        $robotLoader->setTempDirectory(\sys_get_temp_dir() . '/_rector_stubs');
        $robotLoader->register();
        $robotLoader->rebuild();
        $this->areStubsLoaded = \true;
    }
}
