<?php

declare (strict_types=1);
namespace Rector\PHPUnit\Rector\Class_;

use _PhpScoper50d83356d739\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\Class_;
use Rector\AttributeAwarePhpDoc\Ast\PhpDoc\DataProviderTagValueNode;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\Core\Rector\AbstractPHPUnitRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://stackoverflow.com/a/46693675/1348344
 *
 * @see \Rector\PHPUnit\Tests\Rector\Class_\RemoveDataProviderTestPrefixRector\RemoveDataProviderTestPrefixRectorTest
 */
final class RemoveDataProviderTestPrefixRector extends \Rector\Core\Rector\AbstractPHPUnitRector
{
    /**
     * @var string[]
     */
    private $providerMethodNamesToNewNames = [];
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Data provider methods cannot start with "test" prefix', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass extends PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider testProvideData()
     */
    public function test()
    {
        $nothing = 5;
    }

    public function testProvideData()
    {
        return ['123'];
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass extends PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test()
    {
        $nothing = 5;
    }

    public function provideData()
    {
        return ['123'];
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
        if (!$this->isInTestClass($node)) {
            return null;
        }
        $this->providerMethodNamesToNewNames = [];
        $this->renameDataProviderAnnotationsAndCollectRenamedMethods($node);
        $this->renameProviderMethods($node);
        return $node;
    }
    private function renameDataProviderAnnotationsAndCollectRenamedMethods(\PhpParser\Node\Stmt\Class_ $class) : void
    {
        foreach ($class->getMethods() as $classMethod) {
            /** @var PhpDocInfo|null $phpDocInfo */
            $phpDocInfo = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
            if ($phpDocInfo === null) {
                continue;
            }
            /** @var DataProviderTagValueNode[] $dataProviderTagValueNodes */
            $dataProviderTagValueNodes = $phpDocInfo->findAllByType(\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\DataProviderTagValueNode::class);
            if ($dataProviderTagValueNodes === []) {
                continue;
            }
            foreach ($dataProviderTagValueNodes as $dataProviderTagValueNode) {
                $oldMethodName = $dataProviderTagValueNode->getMethod();
                if (!\_PhpScoper50d83356d739\Nette\Utils\Strings::startsWith($oldMethodName, 'test')) {
                    continue;
                }
                $newMethodName = $this->createNewMethodName($oldMethodName);
                $dataProviderTagValueNode->changeMethod($newMethodName);
                $oldMethodName = \trim($oldMethodName, '()');
                $newMethodName = \trim($newMethodName, '()');
                $this->providerMethodNamesToNewNames[$oldMethodName] = $newMethodName;
            }
        }
    }
    private function renameProviderMethods(\PhpParser\Node\Stmt\Class_ $class) : void
    {
        foreach ($class->getMethods() as $classMethod) {
            foreach ($this->providerMethodNamesToNewNames as $oldName => $newName) {
                if (!$this->isName($classMethod, $oldName)) {
                    continue;
                }
                $classMethod->name = new \PhpParser\Node\Identifier($newName);
            }
        }
    }
    private function createNewMethodName(string $oldMethodName) : string
    {
        $newMethodName = \_PhpScoper50d83356d739\Nette\Utils\Strings::substring($oldMethodName, \strlen('test'));
        return \lcfirst($newMethodName);
    }
}
