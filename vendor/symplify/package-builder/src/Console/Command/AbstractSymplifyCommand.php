<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\PackageBuilder\Console\Command;

use _PhpScopere8e811afab72\Symfony\Component\Console\Command\Command;
use _PhpScopere8e811afab72\Symfony\Component\Console\Input\InputOption;
use _PhpScopere8e811afab72\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\ValueObject\Option;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\FileSystemGuard;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\Finder\SmartFinder;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem;
abstract class AbstractSymplifyCommand extends \_PhpScopere8e811afab72\Symfony\Component\Console\Command\Command
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
        $this->addOption(\_PhpScopere8e811afab72\Symplify\PackageBuilder\ValueObject\Option::CONFIG, 'c', \_PhpScopere8e811afab72\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Path to config file');
    }
    /**
     * @required
     */
    public function autowireAbstractSymplifyCommand(\_PhpScopere8e811afab72\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \_PhpScopere8e811afab72\Symplify\SmartFileSystem\Finder\SmartFinder $smartFinder, \_PhpScopere8e811afab72\Symplify\SmartFileSystem\FileSystemGuard $fileSystemGuard) : void
    {
        $this->symfonyStyle = $symfonyStyle;
        $this->smartFileSystem = $smartFileSystem;
        $this->smartFinder = $smartFinder;
        $this->fileSystemGuard = $fileSystemGuard;
    }
}
