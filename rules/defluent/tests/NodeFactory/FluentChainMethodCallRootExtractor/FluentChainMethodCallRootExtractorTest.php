<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Defluent\Tests\NodeFactory\FluentChainMethodCallRootExtractor;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\Rector\Core\HttpKernel\RectorKernel;
use _PhpScopere8e811afab72\Rector\Defluent\NodeAnalyzer\FluentChainMethodCallRootExtractor;
use _PhpScopere8e811afab72\Rector\Defluent\ValueObject\AssignAndRootExpr;
use _PhpScopere8e811afab72\Rector\Defluent\ValueObject\FluentCallsKind;
use _PhpScopere8e811afab72\Rector\Testing\TestingParser\TestingParser;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class FluentChainMethodCallRootExtractorTest extends \_PhpScopere8e811afab72\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var FluentChainMethodCallRootExtractor
     */
    private $fluentChainMethodCallRootExtractor;
    /**
     * @var TestingParser
     */
    private $testingParser;
    protected function setUp() : void
    {
        $this->bootKernel(\_PhpScopere8e811afab72\Rector\Core\HttpKernel\RectorKernel::class);
        $this->fluentChainMethodCallRootExtractor = $this->getService(\_PhpScopere8e811afab72\Rector\Defluent\NodeAnalyzer\FluentChainMethodCallRootExtractor::class);
        $this->testingParser = $this->getService(\_PhpScopere8e811afab72\Rector\Testing\TestingParser\TestingParser::class);
    }
    public function test() : void
    {
        $assignAndRootExpr = $this->parseFileAndCreateAssignAndRootExprForSure(__DIR__ . '/Fixture/variable_double_method_call.php.inc');
        $this->assertFalse($assignAndRootExpr->isFirstCallFactory());
        $this->assertNull($assignAndRootExpr->getSilentVariable());
    }
    public function testFactory() : void
    {
        $assignAndRootExpr = $this->parseFileAndCreateAssignAndRootExprForSure(__DIR__ . '/Fixture/is_factory_variable_double_method_call.php.inc');
        $this->assertTrue($assignAndRootExpr->isFirstCallFactory());
    }
    public function testNew() : void
    {
        $assignAndRootExpr = $this->parseFileAndCreateAssignAndRootExprForSure(__DIR__ . '/Fixture/return_new_double_method_call.php.inc');
        $this->assertFalse($assignAndRootExpr->isFirstCallFactory());
        $silentVariable = $assignAndRootExpr->getSilentVariable();
        /** @var Variable $silentVariable */
        $this->assertInstanceOf(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable::class, $silentVariable);
        $this->assertIsString($silentVariable->name);
        $this->assertSame('someClassWithFluentMethods', $silentVariable->name);
    }
    public function testSingleMethodCallNull() : void
    {
        $assignAndRootExpr = $this->parseFileAndCreateAssignAndRootExpr(__DIR__ . '/Fixture/skip_non_fluent_nette_container_builder.php.inc');
        $this->assertNull($assignAndRootExpr);
    }
    private function parseFileAndCreateAssignAndRootExprForSure(string $filePath) : \_PhpScopere8e811afab72\Rector\Defluent\ValueObject\AssignAndRootExpr
    {
        $assignAndRootExpr = $this->parseFileAndCreateAssignAndRootExpr($filePath);
        $this->assertInstanceOf(\_PhpScopere8e811afab72\Rector\Defluent\ValueObject\AssignAndRootExpr::class, $assignAndRootExpr);
        /** @var AssignAndRootExpr $assignAndRootExpr */
        return $assignAndRootExpr;
    }
    private function parseFileAndCreateAssignAndRootExpr(string $filePath) : ?\_PhpScopere8e811afab72\Rector\Defluent\ValueObject\AssignAndRootExpr
    {
        /** @var MethodCall[] $methodCalls */
        $methodCalls = $this->testingParser->parseFileToDecoratedNodesAndFindNodesByType($filePath, \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall::class);
        return $this->fluentChainMethodCallRootExtractor->extractFromMethodCalls($methodCalls, \_PhpScopere8e811afab72\Rector\Defluent\ValueObject\FluentCallsKind::NORMAL);
    }
}
