<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\Console\Command;

use _PhpScopere8e811afab72\Rector\RectorGenerator\TemplateInitializer;
use _PhpScopere8e811afab72\Symfony\Component\Console\Input\InputInterface;
use _PhpScopere8e811afab72\Symfony\Component\Console\Output\OutputInterface;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Console\ShellCode;
final class InitCommand extends \_PhpScopere8e811afab72\Rector\Core\Console\Command\AbstractCommand
{
    /**
     * @var TemplateInitializer
     */
    private $templateInitializer;
    public function __construct(\_PhpScopere8e811afab72\Rector\RectorGenerator\TemplateInitializer $templateInitializer)
    {
        parent::__construct();
        $this->templateInitializer = $templateInitializer;
    }
    protected function configure() : void
    {
        $this->setDescription('Generate rector.php configuration file');
    }
    protected function execute(\_PhpScopere8e811afab72\Symfony\Component\Console\Input\InputInterface $input, \_PhpScopere8e811afab72\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $this->templateInitializer->initialize(__DIR__ . '/../../../templates/rector.php.dist', 'rector.php');
        return \_PhpScopere8e811afab72\Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
    }
}
