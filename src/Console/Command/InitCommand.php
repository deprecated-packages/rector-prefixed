<?php

declare (strict_types=1);
namespace Rector\Core\Console\Command;

use RectorPrefix20210317\Symfony\Component\Console\Command\Command;
use RectorPrefix20210317\Symfony\Component\Console\Input\InputInterface;
use RectorPrefix20210317\Symfony\Component\Console\Output\OutputInterface;
use RectorPrefix20210317\Symfony\Component\Console\Style\SymfonyStyle;
use RectorPrefix20210317\Symplify\PackageBuilder\Console\ShellCode;
use RectorPrefix20210317\Symplify\SmartFileSystem\FileSystemGuard;
use RectorPrefix20210317\Symplify\SmartFileSystem\SmartFileSystem;
final class InitCommand extends \RectorPrefix20210317\Symfony\Component\Console\Command\Command
{
    /**
     * @var FileSystemGuard
     */
    private $fileSystemGuard;
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;
    /**
     * @param \Symplify\SmartFileSystem\FileSystemGuard $fileSystemGuard
     * @param \Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem
     * @param \Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle
     */
    public function __construct($fileSystemGuard, $smartFileSystem, $symfonyStyle)
    {
        $this->fileSystemGuard = $fileSystemGuard;
        $this->smartFileSystem = $smartFileSystem;
        $this->symfonyStyle = $symfonyStyle;
        parent::__construct();
    }
    protected function configure() : void
    {
        $this->setDescription('Generate rector.php configuration file');
    }
    protected function execute(\RectorPrefix20210317\Symfony\Component\Console\Input\InputInterface $input, \RectorPrefix20210317\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $rectorTemplateFilePath = __DIR__ . '/../../../templates/rector.php.dist';
        $this->fileSystemGuard->ensureFileExists($rectorTemplateFilePath, __METHOD__);
        $rectorRootFilePath = \getcwd() . '/rector.php';
        $doesFileExist = $this->smartFileSystem->exists($rectorRootFilePath);
        if ($doesFileExist) {
            $this->symfonyStyle->warning('Config file "rector.php" already exists');
        } else {
            $this->smartFileSystem->copy($rectorTemplateFilePath, $rectorRootFilePath);
            $this->symfonyStyle->success('"rector.php" config file was added');
        }
        return \RectorPrefix20210317\Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
    }
}
