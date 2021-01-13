<?php

declare (strict_types=1);
namespace Rector\Core\Console\Command;

use RectorPrefix20210113\Nette\Utils\Strings;
use Rector\Caching\Detector\ChangedFilesDetector;
use Rector\Core\Configuration\Option;
use RectorPrefix20210113\Symfony\Component\Console\Command\Command;
use RectorPrefix20210113\Symfony\Component\Console\Descriptor\TextDescriptor;
use RectorPrefix20210113\Symfony\Component\Console\Exception\RuntimeException;
use RectorPrefix20210113\Symfony\Component\Console\Input\InputInterface;
use RectorPrefix20210113\Symfony\Component\Console\Output\OutputInterface;
use RectorPrefix20210113\Symplify\PackageBuilder\Console\ShellCode;
abstract class AbstractCommand extends \RectorPrefix20210113\Symfony\Component\Console\Command\Command
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
    public function autowireAbstractCommand(\RectorPrefix20210113\Symfony\Component\Console\Descriptor\TextDescriptor $textDescriptor, \Rector\Caching\Detector\ChangedFilesDetector $changedFilesDetector) : void
    {
        $this->textDescriptor = $textDescriptor;
        $this->changedFilesDetector = $changedFilesDetector;
    }
    public function run(\RectorPrefix20210113\Symfony\Component\Console\Input\InputInterface $input, \RectorPrefix20210113\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        // show help on arguments fail
        try {
            return parent::run($input, $output);
        } catch (\RectorPrefix20210113\Symfony\Component\Console\Exception\RuntimeException $runtimeException) {
            if (\RectorPrefix20210113\Nette\Utils\Strings::contains($runtimeException->getMessage(), 'Not enough arguments')) {
                // sometimes there is "command" argument, not really needed on fail of chosen command and missing argument
                $inputDefinition = $this->getDefinition();
                $arguments = $inputDefinition->getArguments();
                if (isset($arguments['command'])) {
                    unset($arguments['command']);
                    $inputDefinition->setArguments($arguments);
                }
                $this->textDescriptor->describe($output, $this);
                return \RectorPrefix20210113\Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
            }
            throw $runtimeException;
        }
    }
    protected function initialize(\RectorPrefix20210113\Symfony\Component\Console\Input\InputInterface $input, \RectorPrefix20210113\Symfony\Component\Console\Output\OutputInterface $output) : void
    {
        $application = $this->getApplication();
        $optionDebug = $input->getOption(\Rector\Core\Configuration\Option::OPTION_DEBUG);
        if ($optionDebug) {
            if ($application === null) {
                return;
            }
            $application->setCatchExceptions(\false);
            // clear cache
            $this->changedFilesDetector->clear();
        }
        $optionClearCache = $input->getOption(\Rector\Core\Configuration\Option::OPTION_CLEAR_CACHE);
        // clear cache
        if ($optionClearCache) {
            $this->changedFilesDetector->clear();
        }
    }
}
