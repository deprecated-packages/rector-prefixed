<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\RectorGenerator\Command;

use _PhpScoper0a2ac50786fa\Rector\RectorGenerator\TemplateInitializer;
use _PhpScoper0a2ac50786fa\Symfony\Component\Console\Command\Command;
use _PhpScoper0a2ac50786fa\Symfony\Component\Console\Input\InputInterface;
use _PhpScoper0a2ac50786fa\Symfony\Component\Console\Output\OutputInterface;
use _PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Console\ShellCode;
final class InitRecipeCommand extends \_PhpScoper0a2ac50786fa\Symfony\Component\Console\Command\Command
{
    /**
     * @var TemplateInitializer
     */
    private $templateInitializer;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\RectorGenerator\TemplateInitializer $templateInitializer)
    {
        parent::__construct();
        $this->templateInitializer = $templateInitializer;
    }
    protected function configure() : void
    {
        $this->setDescription('[DEV] Initialize "rector-recipe.php" config');
        $this->setAliases(['recipe-init']);
    }
    protected function execute(\_PhpScoper0a2ac50786fa\Symfony\Component\Console\Input\InputInterface $input, \_PhpScoper0a2ac50786fa\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $this->templateInitializer->initialize(__DIR__ . '/../../../../templates/rector-recipe.php.dist', 'rector-recipe.php');
        return \_PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
    }
}
