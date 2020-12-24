<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPUnit\Rector\Class_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareGenericTagValueNode;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocTagNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\PHPUnit\TestClassResolver\TestClassResolver;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\PHPUnit\Tests\Rector\Class_\AddSeeTestAnnotationRector\AddSeeTestAnnotationRectorTest
 */
final class AddSeeTestAnnotationRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var TestClassResolver
     */
    private $testClassResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\PHPUnit\TestClassResolver\TestClassResolver $testClassResolver)
    {
        $this->testClassResolver = $testClassResolver;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Add @see annotation test of the class for faster jump to test. Make it FQN, so it stays in the annotation, not in the PHP source code.', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeService
{
}

use PHPUnit\Framework\TestCase;

class SomeServiceTest extends TestCase
{
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
/**
 * @see \SomeServiceTest
 */
class SomeService
{
}

use PHPUnit\Framework\TestCase;

class SomeServiceTest extends TestCase
{
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $testCaseClassName = $this->testClassResolver->resolveFromClass($node);
        if ($testCaseClassName === null) {
            return null;
        }
        if ($this->shouldSkipClass($node, $testCaseClassName)) {
            return null;
        }
        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        $seeTagNode = $this->createSeePhpDocTagNode($testCaseClassName);
        $phpDocInfo->addPhpDocTagNode($seeTagNode);
        $this->notifyNodeFileInfo($node);
        return $node;
    }
    private function shouldSkipClass(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class, string $testCaseClassName) : bool
    {
        // we are in the test case
        if ($this->isName($class, '*Test')) {
            return \true;
        }
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $class->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return \true;
        }
        $seeTags = $phpDocInfo->getTagsByName('see');
        // is the @see annotation already added
        foreach ($seeTags as $seeTag) {
            if (!$seeTag->value instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode) {
                continue;
            }
            /** @var GenericTagValueNode $genericTagValueNode */
            $genericTagValueNode = $seeTag->value;
            $seeTagClass = \ltrim($genericTagValueNode->value, '\\');
            if ($seeTagClass === $testCaseClassName) {
                return \true;
            }
        }
        return \false;
    }
    private function createSeePhpDocTagNode(string $className) : \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode
    {
        return new \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocTagNode('@see', new \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareGenericTagValueNode('\\' . $className));
    }
}
