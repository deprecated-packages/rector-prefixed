<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Privatization\Rector\Property;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\PhpAttribute\ValueObject\TagName;
use _PhpScoperb75b35f52b74\Rector\VendorLocker\NodeVendorLocker\PropertyVisibilityVendorLockResolver;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Privatization\Tests\Rector\Property\PrivatizeLocalPropertyToPrivatePropertyRector\PrivatizeLocalPropertyToPrivatePropertyRectorTest
 */
final class PrivatizeLocalPropertyToPrivatePropertyRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[]
     */
    private const ANNOTATIONS_REQUIRING_PUBLIC = [
        'api',
        // Symfony DI
        \_PhpScoperb75b35f52b74\Rector\PhpAttribute\ValueObject\TagName::REQUIRED,
        // other DI
        'inject',
    ];
    /**
     * @var PropertyVisibilityVendorLockResolver
     */
    private $propertyVisibilityVendorLockResolver;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\VendorLocker\NodeVendorLocker\PropertyVisibilityVendorLockResolver $propertyVisibilityVendorLockResolver)
    {
        $this->propertyVisibilityVendorLockResolver = $propertyVisibilityVendorLockResolver;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Privatize local-only property to private property', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property::class];
    }
    /**
     * @param Property $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        $propertyFetches = $this->nodeRepository->findPropertyFetchesByProperty($node);
        $usedPropertyFetchClassNames = [];
        foreach ($propertyFetches as $propertyFetch) {
            $usedPropertyFetchClassNames[] = $propertyFetch->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        }
        $usedPropertyFetchClassNames = \array_unique($usedPropertyFetchClassNames);
        $propertyClassName = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        // has external usage
        if ([$propertyClassName] !== $usedPropertyFetchClassNames) {
            return null;
        }
        $this->makePrivate($node);
        return $node;
    }
    private function shouldSkip(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property) : bool
    {
        $classLike = $property->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
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
        $phpDocInfo = $property->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
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
    private function shouldSkipClass(?\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike $classLike) : bool
    {
        if (!$classLike instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_) {
            return \true;
        }
        if ($this->isAnonymousClass($classLike)) {
            return \true;
        }
        if ($this->isObjectType($classLike, '_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\TestCase')) {
            return \true;
        }
        return $this->isObjectType($classLike, '_PhpScoperb75b35f52b74\\PHP_CodeSniffer\\Sniffs\\Sniff');
    }
    private function shouldSkipProperty(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property) : bool
    {
        // already private
        if ($property->isPrivate()) {
            return \true;
        }
        // skip for now
        return $property->isStatic();
    }
}
