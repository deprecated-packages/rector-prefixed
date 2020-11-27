<?php

declare (strict_types=1);
namespace Rector\Core\Console\Command;

use _PhpScopera143bcca66cb\Nette\Utils\Strings;
use Rector\Caching\Detector\ChangedFilesDetector;
use Rector\Core\Configuration\Option;
use _PhpScopera143bcca66cb\Symfony\Component\Console\Command\Command;
use _PhpScopera143bcca66cb\Symfony\Component\Console\Descriptor\TextDescriptor;
use _PhpScopera143bcca66cb\Symfony\Component\Console\Exception\RuntimeException;
use _PhpScopera143bcca66cb\Symfony\Component\Console\Input\InputInterface;
use _PhpScopera143bcca66cb\Symfony\Component\Console\Output\OutputInterface;
use Symplify\PackageBuilder\Console\ShellCode;
abstract class AbstractCommand extends \_PhpScopera143bcca66cb\Symfony\Component\Console\Command\Command
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
    public function autowireAbstractCommand(\_PhpScopera143bcca66cb\Symfony\Component\Console\Descriptor\TextDescriptor $textDescriptor, \Rector\Caching\Detector\ChangedFilesDetector $changedFilesDetector) : void
    {
        $this->textDescriptor = $textDescriptor;
        $this->changedFilesDetector = $changedFilesDetector;
    }
    public function run(\_PhpScopera143bcca66cb\Symfony\Component\Console\Input\InputInterface $input, \_PhpScopera143bcca66cb\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        // show help on arguments fail
        try {
            return parent::run($input, $output);
        } catch (\_PhpScopera143bcca66cb\Symfony\Component\Console\Exception\RuntimeException $runtimeException) {
            if (\_PhpScopera143bcca66cb\Nette\Utils\Strings::contains($runtimeException->getMessage(), 'Not enough arguments')) {
                // sometimes there is "command" argument, not really needed on fail of chosen command and missing argument
                $inputDefinition = $this->getDefinition();
                $arguments = $inputDefinition->getArguments();
                if (isset($arguments['command'])) {
                    unset($arguments['command']);
                    $inputDefinition->setArguments($arguments);
                }
                $this->textDescriptor->describe($output, $this);
                return \Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
            }
            throw $runtimeException;
        }
    }
    protected function initialize(\_PhpScopera143bcca66cb\Symfony\Component\Console\Input\InputInterface $input, \_PhpScopera143bcca66cb\Symfony\Component\Console\Output\OutputInterface $output) : void
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
