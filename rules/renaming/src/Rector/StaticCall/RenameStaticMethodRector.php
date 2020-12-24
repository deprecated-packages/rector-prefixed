<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Renaming\Rector\StaticCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Identifier;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\RenameStaticMethod;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Renaming\Tests\Rector\StaticCall\RenameStaticMethodRector\RenameStaticMethodRectorTest
 */
final class RenameStaticMethodRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector implements \_PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface
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
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        $renameClassConfiguration = [self::OLD_TO_NEW_METHODS_BY_CLASSES => [new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\RenameStaticMethod(self::SOME_CLASS, 'oldMethod', 'AnotherExampleClass', 'newStaticMethod')]];
        $renameMethodConfiguration = [self::OLD_TO_NEW_METHODS_BY_CLASSES => [new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\RenameStaticMethod(self::SOME_CLASS, 'oldMethod', self::SOME_CLASS, 'newStaticMethod')]];
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns method names to new ones.', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample('SomeClass::oldStaticMethod();', 'AnotherExampleClass::newStaticMethod();', $renameClassConfiguration), new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample('SomeClass::oldStaticMethod();', 'SomeClass::newStaticMethod();', $renameMethodConfiguration)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param StaticCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
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
    private function rename(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall $staticCall, \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\RenameStaticMethod $renameStaticMethod) : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall
    {
        $staticCall->name = new \_PhpScoper0a6b37af0871\PhpParser\Node\Identifier($renameStaticMethod->getNewMethod());
        if ($renameStaticMethod->hasClassChanged()) {
            $staticCall->class = new \_PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified($renameStaticMethod->getNewClass());
        }
        return $staticCall;
    }
}
