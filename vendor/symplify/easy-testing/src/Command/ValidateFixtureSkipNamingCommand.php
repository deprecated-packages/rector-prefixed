<?php

declare (strict_types=1);
namespace RectorPrefix20210108\Symplify\EasyTesting\Command;

use RectorPrefix20210108\Nette\Utils\Strings;
use RectorPrefix20210108\Symfony\Component\Console\Input\InputArgument;
use RectorPrefix20210108\Symfony\Component\Console\Input\InputInterface;
use RectorPrefix20210108\Symfony\Component\Console\Output\OutputInterface;
use RectorPrefix20210108\Symplify\EasyTesting\Finder\FixtureFinder;
use RectorPrefix20210108\Symplify\EasyTesting\MissplacedSkipPrefixResolver;
use RectorPrefix20210108\Symplify\EasyTesting\ValueObject\Option;
use RectorPrefix20210108\Symplify\EasyTesting\ValueObject\Prefix;
use RectorPrefix20210108\Symplify\PackageBuilder\Console\Command\AbstractSymplifyCommand;
use RectorPrefix20210108\Symplify\PackageBuilder\Console\ShellCode;
final class ValidateFixtureSkipNamingCommand extends \RectorPrefix20210108\Symplify\PackageBuilder\Console\Command\AbstractSymplifyCommand
{
    /**
     * @var MissplacedSkipPrefixResolver
     */
    private $missplacedSkipPrefixResolver;
    /**
     * @var FixtureFinder
     */
    private $fixtureFinder;
    public function __construct(\RectorPrefix20210108\Symplify\EasyTesting\MissplacedSkipPrefixResolver $missplacedSkipPrefixResolver, \RectorPrefix20210108\Symplify\EasyTesting\Finder\FixtureFinder $fixtureFinder)
    {
        $this->missplacedSkipPrefixResolver = $missplacedSkipPrefixResolver;
        $this->fixtureFinder = $fixtureFinder;
        parent::__construct();
    }
    protected function configure() : void
    {
        $this->addArgument(\RectorPrefix20210108\Symplify\EasyTesting\ValueObject\Option::SOURCE, \RectorPrefix20210108\Symfony\Component\Console\Input\InputArgument::REQUIRED | \RectorPrefix20210108\Symfony\Component\Console\Input\InputArgument::IS_ARRAY, 'Paths to analyse');
        $this->setDescription('Check that skipped fixture files (without `-----` separator) have a "skip" prefix');
    }
    protected function execute(\RectorPrefix20210108\Symfony\Component\Console\Input\InputInterface $input, \RectorPrefix20210108\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $source = (array) $input->getArgument(\RectorPrefix20210108\Symplify\EasyTesting\ValueObject\Option::SOURCE);
        $fixtureFileInfos = $this->fixtureFinder->find($source);
        $missplacedFixtureFileInfos = $this->missplacedSkipPrefixResolver->resolve($fixtureFileInfos);
        if ($missplacedFixtureFileInfos === []) {
            $message = \sprintf('All %d fixture files have valid names', \count($fixtureFileInfos));
            $this->symfonyStyle->success($message);
            return \RectorPrefix20210108\Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
        }
        foreach ($missplacedFixtureFileInfos as $missplacedFixtureFileInfo) {
            if (\RectorPrefix20210108\Nette\Utils\Strings::match($missplacedFixtureFileInfo->getBasenameWithoutSuffix(), \RectorPrefix20210108\Symplify\EasyTesting\ValueObject\Prefix::SKIP_PREFIX_REGEX)) {
                // A. file has incorrect "skip"
                $baseMessage = 'The file "%s" should drop the "skip" prefix';
            } else {
                // B. file is missing "skip"
                $baseMessage = 'The file "%s" should start with "skip" prefix';
            }
            $errorMessage = \sprintf($baseMessage, $missplacedFixtureFileInfo->getRelativeFilePathFromCwd());
            $this->symfonyStyle->note($errorMessage);
        }
        $errorMessage = \sprintf('Found %d test file fixtures with wrong prefix', \count($missplacedFixtureFileInfos));
        $this->symfonyStyle->error($errorMessage);
        return \RectorPrefix20210108\Symplify\PackageBuilder\Console\ShellCode::ERROR;
    }
}
