<?php

declare (strict_types=1);
namespace Rector\Transform\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\Core\Rector\AbstractRector;
use Rector\Transform\NodeFactory\ConfigFileFactory;
use Rector\Transform\NodeFactory\ProvideConfigFilePathClassMethodFactory;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Tests\Transform\Rector\Class_\NativeTestCaseRector\NativeTestCaseRectorTest
 */
final class NativeTestCaseRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var ProvideConfigFilePathClassMethodFactory
     */
    private $provideConfigFilePathClassMethodFactory;
    /**
     * @var ConfigFileFactory
     */
    private $configFileFactory;
    public function __construct(\Rector\Transform\NodeFactory\ProvideConfigFilePathClassMethodFactory $provideConfigFilePathClassMethodFactory, \Rector\Transform\NodeFactory\ConfigFileFactory $configFileFactory)
    {
        $this->provideConfigFilePathClassMethodFactory = $provideConfigFilePathClassMethodFactory;
        $this->configFileFactory = $configFileFactory;
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
     * @return array<class-string<Node>>
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
        if (!$this->isName($node->extends, 'Rector\\Testing\\PHPUnit\\AbstractRectorTestCase')) {
            return null;
        }
        $getRectorClassMethod = $node->getMethod('getRectorClass');
        if (!$getRectorClassMethod instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return null;
        }
        $this->removeNode($getRectorClassMethod);
        $node->stmts[] = $this->provideConfigFilePathClassMethodFactory->create();
        $this->configFileFactory->createConfigFile($getRectorClassMethod);
        return $node;
    }
}
