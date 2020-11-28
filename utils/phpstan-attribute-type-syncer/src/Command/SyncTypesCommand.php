<?php

declare (strict_types=1);
namespace Rector\Utils\PHPStanAttributeTypeSyncer\Command;

use Rector\AttributeAwarePhpDoc\AttributeAwareNodeFactoryCollector;
use Rector\Core\Console\Command\AbstractCommand;
use Rector\Utils\PHPStanAttributeTypeSyncer\Finder\NodeClassFinder;
use Rector\Utils\PHPStanAttributeTypeSyncer\Generator\AttributeAwareNodeFactoryGenerator;
use Rector\Utils\PHPStanAttributeTypeSyncer\Generator\AttributeAwareNodeGenerator;
use _PhpScoperabd03f0baf05\Symfony\Component\Console\Input\InputInterface;
use _PhpScoperabd03f0baf05\Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symplify\PackageBuilder\Console\ShellCode;
final class SyncTypesCommand extends \Rector\Core\Console\Command\AbstractCommand
{
    /**
     * @var AttributeAwareNodeFactoryCollector
     */
    private $attributeAwareNodeFactoryCollector;
    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;
    /**
     * @var NodeClassFinder
     */
    private $nodeClassFinder;
    /**
     * @var AttributeAwareNodeGenerator
     */
    private $attributeAwareNodeGenerator;
    /**
     * @var AttributeAwareNodeFactoryGenerator
     */
    private $attributeAwareNodeFactoryGenerator;
    public function __construct(\Rector\AttributeAwarePhpDoc\AttributeAwareNodeFactoryCollector $attributeAwareNodeFactoryCollector, \Rector\Utils\PHPStanAttributeTypeSyncer\Generator\AttributeAwareNodeFactoryGenerator $attributeAwareNodeFactoryGenerator, \Rector\Utils\PHPStanAttributeTypeSyncer\Generator\AttributeAwareNodeGenerator $attributeAwareNodeGenerator, \Rector\Utils\PHPStanAttributeTypeSyncer\Finder\NodeClassFinder $nodeClassFinder, \Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle)
    {
        $this->attributeAwareNodeFactoryCollector = $attributeAwareNodeFactoryCollector;
        $this->symfonyStyle = $symfonyStyle;
        $this->nodeClassFinder = $nodeClassFinder;
        $this->attributeAwareNodeGenerator = $attributeAwareNodeGenerator;
        $this->attributeAwareNodeFactoryGenerator = $attributeAwareNodeFactoryGenerator;
        parent::__construct();
    }
    protected function configure() : void
    {
        $this->setDescription('[DEV] Synchronize PHPStan types to attribute aware types in Rectors');
    }
    protected function execute(\_PhpScoperabd03f0baf05\Symfony\Component\Console\Input\InputInterface $input, \_PhpScoperabd03f0baf05\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $missingNodeClasses = $this->getMissingNodeClasses();
        if ($missingNodeClasses === []) {
            $this->symfonyStyle->success('All PHPStan Doc Parser nodes are covered with attribute aware mirror in Rector');
            return \Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
        }
        $this->symfonyStyle->error('These classes are missing their attribute aware brother');
        foreach ($missingNodeClasses as $missingNodeClass) {
            // 1. generate node
            $this->attributeAwareNodeGenerator->generateFromPhpDocParserNodeClass($missingNodeClass);
            // 2. generate node factory...
            $this->attributeAwareNodeFactoryGenerator->generateFromPhpDocParserNodeClass($missingNodeClass);
        }
        return \Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
    }
    /**
     * @return string[]
     */
    private function getMissingNodeClasses() : array
    {
        $phpDocParserTagValueNodeClasses = $this->nodeClassFinder->findCurrentPHPDocParserNodeClasses();
        $supportedNodeClasses = $this->attributeAwareNodeFactoryCollector->getSupportedNodeClasses();
        return \array_diff($phpDocParserTagValueNodeClasses, $supportedNodeClasses);
    }
}
