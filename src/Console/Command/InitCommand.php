<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\Console\Command;

use _PhpScoper0a6b37af0871\Rector\RectorGenerator\TemplateInitializer;
use _PhpScoper0a6b37af0871\Symfony\Component\Console\Input\InputInterface;
use _PhpScoper0a6b37af0871\Symfony\Component\Console\Output\OutputInterface;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Console\ShellCode;
final class InitCommand extends \_PhpScoper0a6b37af0871\Rector\Core\Console\Command\AbstractCommand
{
    /**
     * @var TemplateInitializer
     */
    private $templateInitializer;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\RectorGenerator\TemplateInitializer $templateInitializer)
    {
        parent::__construct();
        $this->templateInitializer = $templateInitializer;
    }
    protected function configure() : void
    {
        $this->setDescription('Generate rector.php configuration file');
    }
    protected function execute(\_PhpScoper0a6b37af0871\Symfony\Component\Console\Input\InputInterface $input, \_PhpScoper0a6b37af0871\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $this->templateInitializer->initialize(__DIR__ . '/../../../templates/rector.php.dist', 'rector.php');
        return \_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
    }
}
