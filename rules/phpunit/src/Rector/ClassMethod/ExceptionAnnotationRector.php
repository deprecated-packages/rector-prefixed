<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPUnit\Rector\ClassMethod;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractPHPUnitRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\PHPUnit\NodeFactory\ExpectExceptionMethodCallFactory;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://thephp.cc/news/2016/02/questioning-phpunit-best-practices
 * @see https://github.com/sebastianbergmann/phpunit/commit/17c09b33ac5d9cad1459ace0ae7b1f942d1e9afd
 *
 * @see \Rector\PHPUnit\Tests\Rector\ClassMethod\ExceptionAnnotationRector\ExceptionAnnotationRectorTest
 */
final class ExceptionAnnotationRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractPHPUnitRector
{
    /**
     * In reversed order, which they should be called in code.
     *
     * @var array<string, string>
     */
    private const ANNOTATION_TO_METHOD = ['expectedExceptionMessageRegExp' => 'expectExceptionMessageRegExp', 'expectedExceptionMessage' => 'expectExceptionMessage', 'expectedExceptionCode' => 'expectExceptionCode', 'expectedException' => 'expectException'];
    /**
     * @var ExpectExceptionMethodCallFactory
     */
    private $expectExceptionMethodCallFactory;
    public function __construct(\_PhpScopere8e811afab72\Rector\PHPUnit\NodeFactory\ExpectExceptionMethodCallFactory $expectExceptionMethodCallFactory)
    {
        $this->expectExceptionMethodCallFactory = $expectExceptionMethodCallFactory;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes `@expectedException annotations to `expectException*()` methods', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
/**
 * @expectedException Exception
 * @expectedExceptionMessage Message
 */
public function test()
{
    // tested code
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
public function test()
{
    $this->expectException('Exception');
    $this->expectExceptionMessage('Message');
    // tested code
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isInTestClass($node)) {
            return null;
        }
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return null;
        }
        foreach (self::ANNOTATION_TO_METHOD as $annotationName => $methodName) {
            if (!$phpDocInfo->hasByName($annotationName)) {
                continue;
            }
            $methodCallExpressions = $this->expectExceptionMethodCallFactory->createFromTagValueNodes($phpDocInfo->getTagsByName($annotationName), $methodName);
            $node->stmts = \array_merge($methodCallExpressions, (array) $node->stmts);
            $phpDocInfo->removeByName($annotationName);
        }
        return $node;
    }
}
