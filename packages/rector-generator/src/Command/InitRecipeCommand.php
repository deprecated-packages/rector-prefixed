<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\RectorGenerator\Command;

use _PhpScoper2a4e7ab1ecbc\Rector\RectorGenerator\TemplateInitializer;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Command\Command;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Input\InputInterface;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Output\OutputInterface;
use _PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Console\ShellCode;
final class InitRecipeCommand extends \_PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Command\Command
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
        $this->setDescription('[DEV] Initialize "rector-recipe.php" config');
        $this->setAliases(['recipe-init']);
    }
    protected function execute(\_PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Input\InputInterface $input, \_PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $this->templateInitializer->initialize(__DIR__ . '/../../../../templates/rector-recipe.php.dist', 'rector-recipe.php');
        return \_PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
    }
}
