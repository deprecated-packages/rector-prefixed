<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\ClassConstFetch;

use _PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\RenameClassConstant;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoper2a4e7ab1ecbc\Webmozart\Assert\Assert;
/**
 * @see \Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstantRector\RenameClassConstantRectorTest
 */
final class RenameClassConstantRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector implements \_PhpScoper2a4e7ab1ecbc\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const CLASS_CONSTANT_RENAME = 'constant_rename';
    /**
     * @var RenameClassConstant[]
     */
    private $classConstantRenames = [];
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        $configuration = [self::CLASS_CONSTANT_RENAME => [new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\RenameClassConstant('SomeClass', 'OLD_CONSTANT', 'NEW_CONSTANT'), new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\RenameClassConstant('SomeClass', 'OTHER_OLD_CONSTANT', 'DifferentClass::NEW_CONSTANT')]];
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replaces defined class constants in their calls.', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
$value = SomeClass::OLD_CONSTANT;
$value = SomeClass::OTHER_OLD_CONSTANT;
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$value = SomeClass::NEW_CONSTANT;
$value = DifferentClass::NEW_CONSTANT;
CODE_SAMPLE
, $configuration)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ClassConstFetch::class];
    }
    /**
     * @param ClassConstFetch $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        foreach ($this->classConstantRenames as $classConstantRename) {
            if (!$this->isObjectType($node, $classConstantRename->getOldClass())) {
                continue;
            }
            if (!$this->isName($node->name, $classConstantRename->getOldConstant())) {
                continue;
            }
            if (\_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::contains($classConstantRename->getNewConstant(), '::')) {
                return $this->createClassConstantFetchNodeFromDoubleColonFormat($classConstantRename->getNewConstant());
            }
            $node->name = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier($classConstantRename->getNewConstant());
            return $node;
        }
        return $node;
    }
    /**
     * @param mixed[] $configuration
     */
    public function configure(array $configuration) : void
    {
        $classConstantRenames = $configuration[self::CLASS_CONSTANT_RENAME] ?? [];
        \_PhpScoper2a4e7ab1ecbc\Webmozart\Assert\Assert::allIsInstanceOf($classConstantRenames, \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\RenameClassConstant::class);
        $this->classConstantRenames = $classConstantRenames;
    }
    private function createClassConstantFetchNodeFromDoubleColonFormat(string $constant) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ClassConstFetch
    {
        [$constantClass, $constantName] = \explode('::', $constant);
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ClassConstFetch(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified($constantClass), new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier($constantName));
    }
}
