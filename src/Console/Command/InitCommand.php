<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\Console\Command;

use _PhpScoperb75b35f52b74\Rector\RectorGenerator\TemplateInitializer;
use _PhpScoperb75b35f52b74\Symfony\Component\Console\Input\InputInterface;
use _PhpScoperb75b35f52b74\Symfony\Component\Console\Output\OutputInterface;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Console\ShellCode;
final class InitCommand extends \_PhpScoperb75b35f52b74\Rector\Core\Console\Command\AbstractCommand
{
    /**
     * @var TemplateInitializer
     */
    private $templateInitializer;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\RectorGenerator\TemplateInitializer $templateInitializer)
    {
        parent::__construct();
        $this->templateInitializer = $templateInitializer;
    }
    protected function configure() : void
    {
        $this->setDescription('Generate rector.php configuration file');
    }
    protected function execute(\_PhpScoperb75b35f52b74\Symfony\Component\Console\Input\InputInterface $input, \_PhpScoperb75b35f52b74\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $this->templateInitializer->initialize(__DIR__ . '/../../../templates/rector.php.dist', 'rector.php');
        return \_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
    }
}
