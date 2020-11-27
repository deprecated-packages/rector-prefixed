<?php

declare (strict_types=1);
namespace Rector\Core\Console\Command;

use _PhpScoper006a73f0e455\Symfony\Component\Console\Input\InputInterface;
use _PhpScoper006a73f0e455\Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symplify\PackageBuilder\Console\ShellCode;
use Symplify\SmartFileSystem\SmartFileSystem;
final class InitCommand extends \Rector\Core\Console\Command\AbstractCommand
{
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;
    public function __construct(\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle)
    {
        parent::__construct();
        $this->smartFileSystem = $smartFileSystem;
        $this->symfonyStyle = $symfonyStyle;
    }
    protected function configure() : void
    {
        $this->setDescription('Generate rector.php configuration file');
    }
    protected function execute(\_PhpScoper006a73f0e455\Symfony\Component\Console\Input\InputInterface $input, \_PhpScoper006a73f0e455\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $rectorConfigFiles = $this->smartFileSystem->exists(\getcwd() . '/rector.php');
        if (!$rectorConfigFiles) {
            $this->smartFileSystem->copy(__DIR__ . '/../../../templates/rector.php.dist', \getcwd() . '/rector.php');
            $this->symfonyStyle->success('"rector.php" config file has been generated successfully!');
        } else {
            $this->symfonyStyle->error('Config file not generated. A "rector.php" configuration file already exists');
        }
        return \Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
    }
}
