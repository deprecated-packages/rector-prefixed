<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Renaming\Rector\StaticCall;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameStaticMethod;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Renaming\Tests\Rector\StaticCall\RenameStaticMethodRector\RenameStaticMethodRectorTest
 */
final class RenameStaticMethodRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector implements \_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const OLD_TO_NEW_METHODS_BY_CLASSES = 'old_to_new_method_by_classes';
    /**
     * @var string
     */
    private const SOME_CLASS = 'SomeClass';
    /**
     * @var RenameStaticMethod[]
     */
    private $staticMethodRenames = [];
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        $renameClassConfiguration = [self::OLD_TO_NEW_METHODS_BY_CLASSES => [new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameStaticMethod(self::SOME_CLASS, 'oldMethod', 'AnotherExampleClass', 'newStaticMethod')]];
        $renameMethodConfiguration = [self::OLD_TO_NEW_METHODS_BY_CLASSES => [new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameStaticMethod(self::SOME_CLASS, 'oldMethod', self::SOME_CLASS, 'newStaticMethod')]];
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns method names to new ones.', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample('SomeClass::oldStaticMethod();', 'AnotherExampleClass::newStaticMethod();', $renameClassConfiguration), new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample('SomeClass::oldStaticMethod();', 'SomeClass::newStaticMethod();', $renameMethodConfiguration)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param StaticCall $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        foreach ($this->staticMethodRenames as $staticMethodRename) {
            if (!$this->isObjectType($node->class, $staticMethodRename->getOldClass())) {
                continue;
            }
            if (!$this->isName($node->name, $staticMethodRename->getOldMethod())) {
                continue;
            }
            return $this->rename($node, $staticMethodRename);
        }
        return null;
    }
    public function configure(array $configuration) : void
    {
        $this->staticMethodRenames = $configuration[self::OLD_TO_NEW_METHODS_BY_CLASSES] ?? [];
    }
    private function rename(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall $staticCall, \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameStaticMethod $renameStaticMethod) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall
    {
        $staticCall->name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier($renameStaticMethod->getNewMethod());
        if ($renameStaticMethod->hasClassChanged()) {
            $staticCall->class = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified($renameStaticMethod->getNewClass());
        }
        return $staticCall;
    }
}
