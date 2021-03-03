<?php

declare (strict_types=1);
namespace Rector\Core\Console\Command;

use Rector\RectorGenerator\TemplateInitializer;
use RectorPrefix20210303\Symfony\Component\Console\Command\Command;
use RectorPrefix20210303\Symfony\Component\Console\Input\InputInterface;
use RectorPrefix20210303\Symfony\Component\Console\Output\OutputInterface;
use RectorPrefix20210303\Symplify\PackageBuilder\Console\ShellCode;
final class InitCommand extends \RectorPrefix20210303\Symfony\Component\Console\Command\Command
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
    protected function execute(\RectorPrefix20210303\Symfony\Component\Console\Input\InputInterface $input, \RectorPrefix20210303\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $this->templateInitializer->initialize(__DIR__ . '/../../../templates/rector.php.dist', 'rector.php');
        return \RectorPrefix20210303\Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
    }
}
