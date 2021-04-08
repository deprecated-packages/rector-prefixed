<?php

declare (strict_types=1);
namespace RectorPrefix20210408\Symplify\PackageBuilder\Console\Command;

use RectorPrefix20210408\Symfony\Component\Console\Command\Command;
use RectorPrefix20210408\Symfony\Component\Console\Input\InputOption;
use RectorPrefix20210408\Symfony\Component\Console\Style\SymfonyStyle;
use RectorPrefix20210408\Symplify\PackageBuilder\ValueObject\Option;
use RectorPrefix20210408\Symplify\SmartFileSystem\FileSystemGuard;
use RectorPrefix20210408\Symplify\SmartFileSystem\Finder\SmartFinder;
use RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileSystem;
abstract class AbstractSymplifyCommand extends \RectorPrefix20210408\Symfony\Component\Console\Command\Command
{
    /**
     * @var SymfonyStyle
     */
    protected $symfonyStyle;
    /**
     * @var SmartFileSystem
     */
    protected $smartFileSystem;
    /**
     * @var SmartFinder
     */
    protected $smartFinder;
    /**
     * @var FileSystemGuard
     */
    protected $fileSystemGuard;
    public function __construct()
    {
        parent::__construct();
        $this->addOption(\RectorPrefix20210408\Symplify\PackageBuilder\ValueObject\Option::CONFIG, 'c', \RectorPrefix20210408\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Path to config file');
    }
    /**
     * @required
     */
    public function autowireAbstractSymplifyCommand(\RectorPrefix20210408\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \RectorPrefix20210408\Symplify\SmartFileSystem\Finder\SmartFinder $smartFinder, \RectorPrefix20210408\Symplify\SmartFileSystem\FileSystemGuard $fileSystemGuard) : void
    {
        $this->symfonyStyle = $symfonyStyle;
        $this->smartFileSystem = $smartFileSystem;
        $this->smartFinder = $smartFinder;
        $this->fileSystemGuard = $fileSystemGuard;
    }
}
