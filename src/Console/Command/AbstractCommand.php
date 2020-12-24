<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\Console\Command;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\Rector\Caching\Detector\ChangedFilesDetector;
use _PhpScoperb75b35f52b74\Rector\Core\Configuration\Option;
use _PhpScoperb75b35f52b74\Symfony\Component\Console\Command\Command;
use _PhpScoperb75b35f52b74\Symfony\Component\Console\Descriptor\TextDescriptor;
use _PhpScoperb75b35f52b74\Symfony\Component\Console\Exception\RuntimeException;
use _PhpScoperb75b35f52b74\Symfony\Component\Console\Input\InputInterface;
use _PhpScoperb75b35f52b74\Symfony\Component\Console\Output\OutputInterface;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Console\ShellCode;
abstract class AbstractCommand extends \_PhpScoperb75b35f52b74\Symfony\Component\Console\Command\Command
{
    /**
     * @var ChangedFilesDetector
     */
    protected $changedFilesDetector;
    /**
     * @var TextDescriptor
     */
    private $textDescriptor;
    /**
     * @required
     */
    public function autowireAbstractCommand(\_PhpScoperb75b35f52b74\Symfony\Component\Console\Descriptor\TextDescriptor $textDescriptor, \_PhpScoperb75b35f52b74\Rector\Caching\Detector\ChangedFilesDetector $changedFilesDetector) : void
    {
        $this->textDescriptor = $textDescriptor;
        $this->changedFilesDetector = $changedFilesDetector;
    }
    public function run(\_PhpScoperb75b35f52b74\Symfony\Component\Console\Input\InputInterface $input, \_PhpScoperb75b35f52b74\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        // show help on arguments fail
        try {
            return parent::run($input, $output);
        } catch (\_PhpScoperb75b35f52b74\Symfony\Component\Console\Exception\RuntimeException $runtimeException) {
            if (\_PhpScoperb75b35f52b74\Nette\Utils\Strings::contains($runtimeException->getMessage(), 'Not enough arguments')) {
                // sometimes there is "command" argument, not really needed on fail of chosen command and missing argument
                $inputDefinition = $this->getDefinition();
                $arguments = $inputDefinition->getArguments();
                if (isset($arguments['command'])) {
                    unset($arguments['command']);
                    $inputDefinition->setArguments($arguments);
                }
                $this->textDescriptor->describe($output, $this);
                return \_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
            }
            throw $runtimeException;
        }
    }
    protected function initialize(\_PhpScoperb75b35f52b74\Symfony\Component\Console\Input\InputInterface $input, \_PhpScoperb75b35f52b74\Symfony\Component\Console\Output\OutputInterface $output) : void
    {
        $application = $this->getApplication();
        $optionDebug = $input->getOption(\_PhpScoperb75b35f52b74\Rector\Core\Configuration\Option::OPTION_DEBUG);
        if ($optionDebug) {
            if ($application === null) {
                return;
            }
            $application->setCatchExceptions(\false);
            // clear cache
            $this->changedFilesDetector->clear();
        }
        $optionClearCache = $input->getOption(\_PhpScoperb75b35f52b74\Rector\Core\Configuration\Option::OPTION_CLEAR_CACHE);
        // clear cache
        if ($optionClearCache) {
            $this->changedFilesDetector->clear();
        }
    }
}
