<?php

declare (strict_types=1);
namespace Rector\Core\Console\Command;

use Rector\RectorGenerator\TemplateInitializer;
use RectorPrefix2020DecSat\Symfony\Component\Console\Input\InputInterface;
use RectorPrefix2020DecSat\Symfony\Component\Console\Output\OutputInterface;
use Symplify\PackageBuilder\Console\ShellCode;
final class InitCommand extends \Rector\Core\Console\Command\AbstractCommand
{
    /**
     * @var TemplateInitializer
     */
    private $templateInitializer;
    public function __construct(\Rector\RectorGenerator\TemplateInitializer $templateInitializer)
    {
        parent::__construct();
        $this->templateInitializer = $templateInitializer;
    }
    protected function configure() : void
    {
        $this->setDescription('Generate rector.php configuration file');
    }
    protected function execute(\RectorPrefix2020DecSat\Symfony\Component\Console\Input\InputInterface $input, \RectorPrefix2020DecSat\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $this->templateInitializer->initialize(__DIR__ . '/../../../templates/rector.php.dist', 'rector.php');
        return \Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
    }
}
