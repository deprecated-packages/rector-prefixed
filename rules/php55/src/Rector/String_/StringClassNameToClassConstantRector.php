<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php55\Rector\String_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Core\Util\StaticRectorStrings;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\ClassExistenceStaticHelper;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use ReflectionClass;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://wiki.php.net/rfc/class_name_scalars
 * @see https://github.com/symfony/symfony/blob/2.8/UPGRADE-2.8.md#form
 *
 * @see \Rector\Php55\Tests\Rector\String_\StringClassNameToClassConstantRector\StringClassNameToClassConstantRectorTest
 */
final class StringClassNameToClassConstantRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @api
     * @var string
     */
    public const CLASSES_TO_SKIP = '$classesToSkip';
    /**
     * @var string[]
     */
    private $classesToSkip = [
        // can be string
        'Error',
        'Exception',
    ];
    /**
     * @var string[]
     */
    private $sensitiveExistingClasses = [];
    /**
     * @var string[]
     */
    private $sensitiveNonExistingClasses = [];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replace string class names by <class>::class constant', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_::class];
    }
    /**
     * @param String_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isAtLeastPhpVersion(\_PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature::CLASSNAME_CONSTANT)) {
            return null;
        }
        $classLikeName = $node->value;
        // remove leading slash
        $classLikeName = \ltrim($classLikeName, '\\');
        if ($classLikeName === '') {
            return null;
        }
        if (!$this->classLikeSensitiveExists($classLikeName)) {
            return null;
        }
        if (\_PhpScopere8e811afab72\Rector\Core\Util\StaticRectorStrings::isInArrayInsensitive($classLikeName, $this->classesToSkip)) {
            return null;
        }
        $fullyQualified = new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified($classLikeName);
        /** @see \Rector\PostRector\Collector\UseNodesToAddCollector::isShortImported() */
        $fullyQualified->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO, $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO));
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch($fullyQualified, 'class');
    }
    public function configure(array $configuration) : void
    {
        if (isset($configuration[self::CLASSES_TO_SKIP])) {
            $this->classesToSkip = $configuration[self::CLASSES_TO_SKIP];
        }
    }
    private function classLikeSensitiveExists(string $classLikeName) : bool
    {
        if (!\_PhpScopere8e811afab72\Rector\NodeTypeResolver\ClassExistenceStaticHelper::doesClassLikeExist($classLikeName)) {
            return \false;
        }
        // already known values
        if (\in_array($classLikeName, $this->sensitiveExistingClasses, \true)) {
            return \true;
        }
        if (\in_array($classLikeName, $this->sensitiveNonExistingClasses, \true)) {
            return \false;
        }
        $reflectionClass = new \ReflectionClass($classLikeName);
        if ($classLikeName !== $reflectionClass->getName()) {
            $this->sensitiveNonExistingClasses[] = $classLikeName;
            return \false;
        }
        $this->sensitiveExistingClasses[] = $classLikeName;
        return \true;
    }
}
