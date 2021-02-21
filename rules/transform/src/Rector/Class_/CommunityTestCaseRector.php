<?php

declare (strict_types=1);
namespace Rector\Transform\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Return_;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\Rector\AbstractRector;
use Rector\FileSystemRector\ValueObject\AddedFileWithContent;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\Testing\PhpConfigPrinter\PhpConfigPrinterFactory;
use Rector\Transform\NodeFactory\ProvideConfigFilePathClassMethodFactory;
use RectorPrefix20210221\Symplify\PhpConfigPrinter\Printer\SmartPhpConfigPrinter;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use RectorPrefix20210221\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Rector\Transform\Tests\Rector\Class_\CommunityTestCaseRector\CommunityTestCaseRectorTest
 */
final class CommunityTestCaseRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    private const ABSTRACT_COMMUNITY_TEST_CLASS = 'Rector\\Testing\\PHPUnit\\AbstractCommunityRectorTestCase';
    /**
     * @var ProvideConfigFilePathClassMethodFactory
     */
    private $provideConfigFilePathClassMethodFactory;
    /**
     * @var SmartPhpConfigPrinter
     */
    private $smartPhpConfigPrinter;
    public function __construct(\Rector\Transform\NodeFactory\ProvideConfigFilePathClassMethodFactory $provideConfigFilePathClassMethodFactory, \Rector\Testing\PhpConfigPrinter\PhpConfigPrinterFactory $phpConfigPrinterFactory)
    {
        $this->provideConfigFilePathClassMethodFactory = $provideConfigFilePathClassMethodFactory;
        $this->smartPhpConfigPrinter = $phpConfigPrinterFactory->create();
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change Rector test case to Community version', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Rector\Testing\PHPUnit\AbstractRectorTestCase;

final class SomeClassTest extends AbstractRectorTestCase
{
    public function getRectorClass(): string
    {
        return SomeRector::class;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Rector\Testing\PHPUnit\AbstractCommunityRectorTestCase;

final class SomeClassTest extends AbstractCommunityRectorTestCase
{
    public function provideConfigFilePath(): string
    {
        return __DIR__ . '/config/configured_rule.php';
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($node->extends === null) {
            return null;
        }
        if (!$this->isNames($node->extends, [self::ABSTRACT_COMMUNITY_TEST_CLASS, 'Rector\\Testing\\PHPUnit\\AbstractRectorTestCase'])) {
            return null;
        }
        $getRectorClassMethod = $node->getMethod('getRectorClass');
        if (!$getRectorClassMethod instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return null;
        }
        $node->extends = new \PhpParser\Node\Name\FullyQualified(self::ABSTRACT_COMMUNITY_TEST_CLASS);
        $this->removeNode($getRectorClassMethod);
        $node->stmts[] = $this->provideConfigFilePathClassMethodFactory->create();
        $this->createConfigFile($getRectorClassMethod);
        return $node;
    }
    private function createConfigFile(\PhpParser\Node\Stmt\ClassMethod $getRectorClassMethod) : void
    {
        $onlyStmt = $getRectorClassMethod->stmts[0] ?? null;
        if (!$onlyStmt instanceof \PhpParser\Node\Stmt\Return_) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        if (!$onlyStmt->expr instanceof \PhpParser\Node\Expr\ClassConstFetch) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $rectorClass = $this->valueResolver->getValue($onlyStmt->expr);
        if (!\is_string($rectorClass)) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $phpConfigFileContent = $this->smartPhpConfigPrinter->printConfiguredServices([$rectorClass => null]);
        $fileInfo = $getRectorClassMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
        if (!$fileInfo instanceof \RectorPrefix20210221\Symplify\SmartFileSystem\SmartFileInfo) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $configFilePath = \dirname($fileInfo->getRealPath()) . '/config/configured_rule.php';
        $addedFileWithContent = new \Rector\FileSystemRector\ValueObject\AddedFileWithContent($configFilePath, $phpConfigFileContent);
        $this->removedAndAddedFilesCollector->addAddedFile($addedFileWithContent);
    }
}
