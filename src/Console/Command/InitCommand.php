<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Core\Console\Command;

use _PhpScoper2a4e7ab1ecbc\Rector\RectorGenerator\TemplateInitializer;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Input\InputInterface;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Output\OutputInterface;
use _PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Console\ShellCode;
final class InitCommand extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Console\Command\AbstractCommand
{
    /**
     * @var TemplateInitializer
     */
    private $templateInitializer;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\RectorGenerator\TemplateInitializer $templateInitializer)
    {
        parent::__construct();
        $this->templateInitializer = $templateInitializer;
    }
    protected function configure() : void
    {
        $this->setDescription('Generate rector.php configuration file');
    }
    protected function execute(\_PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Input\InputInterface $input, \_PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $this->templateInitializer->initialize(__DIR__ . '/../../../templates/rector.php.dist', 'rector.php');
        return \_PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
    }
}
