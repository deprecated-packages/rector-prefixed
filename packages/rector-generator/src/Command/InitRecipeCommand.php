<?php

declare (strict_types=1);
namespace Rector\RectorGenerator\Command;

use Rector\RectorGenerator\TemplateInitializer;
use RectorPrefix20210307\Symfony\Component\Console\Command\Command;
use RectorPrefix20210307\Symfony\Component\Console\Input\InputInterface;
use RectorPrefix20210307\Symfony\Component\Console\Output\OutputInterface;
use RectorPrefix20210307\Symplify\PackageBuilder\Console\ShellCode;
final class InitRecipeCommand extends \RectorPrefix20210307\Symfony\Component\Console\Command\Command
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
        $this->setDescription('[DEV] Initialize "rector-recipe.php" config');
    }
    protected function execute(\RectorPrefix20210307\Symfony\Component\Console\Input\InputInterface $input, \RectorPrefix20210307\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $this->templateInitializer->initialize(__DIR__ . '/../../../../templates/rector-recipe.php.dist', 'rector-recipe.php');
        return \RectorPrefix20210307\Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
    }
}
