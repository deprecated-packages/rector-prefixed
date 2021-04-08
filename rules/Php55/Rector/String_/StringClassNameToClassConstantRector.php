<?php

declare (strict_types=1);
namespace Rector\Php55\Rector\String_;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\ClassConst;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\Util\StaticRectorStrings;
use Rector\Core\ValueObject\PhpVersionFeature;
use Rector\NodeTypeResolver\Node\AttributeKey;
use RectorPrefix20210408\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://wiki.php.net/rfc/class_name_scalars
 * @see https://github.com/symfony/symfony/blob/2.8/UPGRADE-2.8.md#form
 *
 * @see \Rector\Tests\Php55\Rector\String_\StringClassNameToClassConstantRector\StringClassNameToClassConstantRectorTest
 */
final class StringClassNameToClassConstantRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @api
     * @var string
     */
    public const CLASSES_TO_SKIP = 'classes_to_skip';
    /**
     * @var string[]
     */
    private $classesToSkip = [
        // can be string
        'Error',
        'Exception',
    ];
    /**
     * @var ClassLikeExistenceChecker
     */
    private $classLikeExistenceChecker;
    public function __construct(\RectorPrefix20210408\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker $classLikeExistenceChecker)
    {
        $this->classLikeExistenceChecker = $classLikeExistenceChecker;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replace string class names by <class>::class constant', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
class AnotherClass
{
}

class SomeClass
{
    public function run()
    {
        return 'AnotherClass';
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class AnotherClass
{
}

class SomeClass
{
    public function run()
    {
        return \AnotherClass::class;
    }
}
CODE_SAMPLE
, [self::CLASSES_TO_SKIP => ['ClassName', 'AnotherClassName']])]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Scalar\String_::class];
    }
    /**
     * @param String_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->isAtLeastPhpVersion(\Rector\Core\ValueObject\PhpVersionFeature::CLASSNAME_CONSTANT)) {
            return null;
        }
        $classLikeName = $node->value;
        // remove leading slash
        $classLikeName = \ltrim($classLikeName, '\\');
        if ($classLikeName === '') {
            return null;
        }
        if ($this->shouldSkip($classLikeName, $node)) {
            return null;
        }
        $fullyQualified = new \PhpParser\Node\Name\FullyQualified($classLikeName);
        /** @see \Rector\PostRector\Collector\UseNodesToAddCollector::isShortImported() */
        $fullyQualified->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO, $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO));
        return new \PhpParser\Node\Expr\ClassConstFetch($fullyQualified, 'class');
    }
    /**
     * @param array<string, string[]> $configuration
     */
    public function configure(array $configuration) : void
    {
        if (!isset($configuration[self::CLASSES_TO_SKIP])) {
            return;
        }
        $this->classesToSkip = $configuration[self::CLASSES_TO_SKIP];
    }
    private function isPartOfIsAFuncCall(\PhpParser\Node\Scalar\String_ $string) : bool
    {
        $parent = $string->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parent instanceof \PhpParser\Node\Arg) {
            return \false;
        }
        $parentParent = $parent->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentParent instanceof \PhpParser\Node\Expr\FuncCall) {
            return \false;
        }
        return $this->nodeNameResolver->isName($parentParent, 'is_a');
    }
    private function shouldSkip(string $classLikeName, \PhpParser\Node\Scalar\String_ $string) : bool
    {
        if (!$this->classLikeExistenceChecker->doesClassLikeInsensitiveExists($classLikeName)) {
            return \true;
        }
        if (\Rector\Core\Util\StaticRectorStrings::isInArrayInsensitive($classLikeName, $this->classesToSkip)) {
            return \true;
        }
        if ($this->isPartOfIsAFuncCall($string)) {
            return \true;
        }
        // allow class strings to be part of class const arrays, as probably on purpose
        $parentClassConst = $this->betterNodeFinder->findParentType($string, \PhpParser\Node\Stmt\ClassConst::class);
        return $parentClassConst instanceof \PhpParser\Node\Stmt\ClassConst;
    }
}
