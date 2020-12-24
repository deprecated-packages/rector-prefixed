<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\Console\Command;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\Rector\Caching\Detector\ChangedFilesDetector;
use _PhpScopere8e811afab72\Rector\Core\Configuration\Option;
use _PhpScopere8e811afab72\Symfony\Component\Console\Command\Command;
use _PhpScopere8e811afab72\Symfony\Component\Console\Descriptor\TextDescriptor;
use _PhpScopere8e811afab72\Symfony\Component\Console\Exception\RuntimeException;
use _PhpScopere8e811afab72\Symfony\Component\Console\Input\InputInterface;
use _PhpScopere8e811afab72\Symfony\Component\Console\Output\OutputInterface;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Console\ShellCode;
abstract class AbstractCommand extends \_PhpScopere8e811afab72\Symfony\Component\Console\Command\Command
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
    public function autowireAbstractCommand(\_PhpScopere8e811afab72\Symfony\Component\Console\Descriptor\TextDescriptor $textDescriptor, \_PhpScopere8e811afab72\Rector\Caching\Detector\ChangedFilesDetector $changedFilesDetector) : void
    {
        $this->textDescriptor = $textDescriptor;
        $this->changedFilesDetector = $changedFilesDetector;
    }
    public function run(\_PhpScopere8e811afab72\Symfony\Component\Console\Input\InputInterface $input, \_PhpScopere8e811afab72\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        // show help on arguments fail
        try {
            return parent::run($input, $output);
        } catch (\_PhpScopere8e811afab72\Symfony\Component\Console\Exception\RuntimeException $runtimeException) {
            if (\_PhpScopere8e811afab72\Nette\Utils\Strings::contains($runtimeException->getMessage(), 'Not enough arguments')) {
                // sometimes there is "command" argument, not really needed on fail of chosen command and missing argument
                $inputDefinition = $this->getDefinition();
                $arguments = $inputDefinition->getArguments();
                if (isset($arguments['command'])) {
                    unset($arguments['command']);
                    $inputDefinition->setArguments($arguments);
                }
                $this->textDescriptor->describe($output, $this);
                return \_PhpScopere8e811afab72\Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
            }
            throw $runtimeException;
        }
    }
    protected function initialize(\_PhpScopere8e811afab72\Symfony\Component\Console\Input\InputInterface $input, \_PhpScopere8e811afab72\Symfony\Component\Console\Output\OutputInterface $output) : void
    {
        $application = $this->getApplication();
        $optionDebug = $input->getOption(\_PhpScopere8e811afab72\Rector\Core\Configuration\Option::OPTION_DEBUG);
        if ($optionDebug) {
            if ($application === null) {
                return;
            }
            $application->setCatchExceptions(\false);
            // clear cache
            $this->changedFilesDetector->clear();
        }
        $optionClearCache = $input->getOption(\_PhpScopere8e811afab72\Rector\Core\Configuration\Option::OPTION_CLEAR_CACHE);
        // clear cache
        if ($optionClearCache) {
            $this->changedFilesDetector->clear();
        }
    }
}
