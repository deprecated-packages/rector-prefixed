<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Privatization\Rector\Property;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\PhpAttribute\ValueObject\TagName;
use _PhpScopere8e811afab72\Rector\VendorLocker\NodeVendorLocker\PropertyVisibilityVendorLockResolver;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Privatization\Tests\Rector\Property\PrivatizeLocalPropertyToPrivatePropertyRector\PrivatizeLocalPropertyToPrivatePropertyRectorTest
 */
final class PrivatizeLocalPropertyToPrivatePropertyRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[]
     */
    private const ANNOTATIONS_REQUIRING_PUBLIC = [
        'api',
        // Symfony DI
        \_PhpScopere8e811afab72\Rector\PhpAttribute\ValueObject\TagName::REQUIRED,
        // other DI
        'inject',
    ];
    /**
     * @var PropertyVisibilityVendorLockResolver
     */
    private $propertyVisibilityVendorLockResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\VendorLocker\NodeVendorLocker\PropertyVisibilityVendorLockResolver $propertyVisibilityVendorLockResolver)
    {
        $this->propertyVisibilityVendorLockResolver = $propertyVisibilityVendorLockResolver;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Privatize local-only property to private property', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public $value;

    public function run()
    {
        return $this->value;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    private $value;

    public function run()
    {
        return $this->value;
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property::class];
    }
    /**
     * @param Property $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        $propertyFetches = $this->nodeRepository->findPropertyFetchesByProperty($node);
        $usedPropertyFetchClassNames = [];
        foreach ($propertyFetches as $propertyFetch) {
            $usedPropertyFetchClassNames[] = $propertyFetch->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        }
        $usedPropertyFetchClassNames = \array_unique($usedPropertyFetchClassNames);
        $propertyClassName = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        // has external usage
        if ([$propertyClassName] !== $usedPropertyFetchClassNames) {
            return null;
        }
        $this->makePrivate($node);
        return $node;
    }
    private function shouldSkip(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property) : bool
    {
        $classLike = $property->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($this->shouldSkipClass($classLike)) {
            return \true;
        }
        if ($this->shouldSkipProperty($property)) {
            return \true;
        }
        // is parent required property? skip it
        if ($this->propertyVisibilityVendorLockResolver->isParentLockedProperty($property)) {
            return \true;
        }
        if ($this->propertyVisibilityVendorLockResolver->isChildLockedProperty($property)) {
            return \true;
        }
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return \false;
        }
        foreach (self::ANNOTATIONS_REQUIRING_PUBLIC as $annotationRequiringPublic) {
            if ($phpDocInfo->hasByName($annotationRequiringPublic)) {
                return \true;
            }
        }
        return \false;
    }
    private function shouldSkipClass(?\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike $classLike) : bool
    {
        if (!$classLike instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_) {
            return \true;
        }
        if ($this->isAnonymousClass($classLike)) {
            return \true;
        }
        if ($this->isObjectType($classLike, '_PhpScopere8e811afab72\\PHPUnit\\Framework\\TestCase')) {
            return \true;
        }
        return $this->isObjectType($classLike, '_PhpScopere8e811afab72\\PHP_CodeSniffer\\Sniffs\\Sniff');
    }
    private function shouldSkipProperty(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property) : bool
    {
        // already private
        if ($property->isPrivate()) {
            return \true;
        }
        // skip for now
        return $property->isStatic();
    }
}
