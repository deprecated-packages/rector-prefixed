<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Console\Command;

use _PhpScoper0a2ac50786fa\Symfony\Component\Console\Command\Command;
use _PhpScoper0a2ac50786fa\Symfony\Component\Console\Input\InputOption;
use _PhpScoper0a2ac50786fa\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScoper0a2ac50786fa\Symplify\PackageBuilder\ValueObject\Option;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\FileSystemGuard;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\Finder\SmartFinder;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileSystem;
abstract class AbstractSymplifyCommand extends \_PhpScoper0a2ac50786fa\Symfony\Component\Console\Command\Command
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
        $this->addOption(\_PhpScoper0a2ac50786fa\Symplify\PackageBuilder\ValueObject\Option::CONFIG, 'c', \_PhpScoper0a2ac50786fa\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Path to config file');
    }
    /**
     * @required
     */
    public function autowireAbstractSymplifyCommand(\_PhpScoper0a2ac50786fa\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\Finder\SmartFinder $smartFinder, \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\FileSystemGuard $fileSystemGuard) : void
    {
        $this->symfonyStyle = $symfonyStyle;
        $this->smartFileSystem = $smartFileSystem;
        $this->smartFinder = $smartFinder;
        $this->fileSystemGuard = $fileSystemGuard;
    }
}
