<?php

declare (strict_types=1);
namespace Rector\PHPUnit\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareGenericTagValueNode;
use Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocTagNode;
use Rector\Core\Rector\AbstractRector;
use Rector\PHPUnit\TestClassResolver\TestClassResolver;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\PHPUnit\Tests\Rector\Class_\AddSeeTestAnnotationRector\AddSeeTestAnnotationRectorTest
 */
final class AddSeeTestAnnotationRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var TestClassResolver
     */
    private $testClassResolver;
    public function __construct(\Rector\PHPUnit\TestClassResolver\TestClassResolver $testClassResolver)
    {
        $this->testClassResolver = $testClassResolver;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Add @see annotation test of the class for faster jump to test. Make it FQN, so it stays in the annotation, not in the PHP source code.', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $testCaseClassName = $this->testClassResolver->resolveFromClass($node);
        if ($testCaseClassName === null) {
            return null;
        }
        if ($this->shouldSkipClass($node, $testCaseClassName)) {
            return null;
        }
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($node);
        $seeTagNode = $this->createSeePhpDocTagNode($testCaseClassName);
        $phpDocInfo->addPhpDocTagNode($seeTagNode);
        return $node;
    }
    private function shouldSkipClass(\PhpParser\Node\Stmt\Class_ $class, string $testCaseClassName) : bool
    {
        // we are in the test case
        if ($this->isName($class, '*Test')) {
            return \true;
        }
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($class);
        $seeTags = $phpDocInfo->getTagsByName('see');
        // is the @see annotation already added
        foreach ($seeTags as $seeTag) {
            if (!$seeTag->value instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode) {
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
    private function createSeePhpDocTagNode(string $className) : \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode
    {
        return new \Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocTagNode('@see', new \Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareGenericTagValueNode('\\' . $className));
    }
}
