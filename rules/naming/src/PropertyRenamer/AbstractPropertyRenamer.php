<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Naming\PropertyRenamer;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\PhpParser\Node\VarLikeIdentifier;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScoperb75b35f52b74\Rector\Naming\Contract\Guard\ConflictingGuardInterface;
use _PhpScoperb75b35f52b74\Rector\Naming\Contract\RenameGuard\RenameGuardInterface;
use _PhpScoperb75b35f52b74\Rector\Naming\Contract\RenamerInterface;
use _PhpScoperb75b35f52b74\Rector\Naming\Contract\RenameValueObjectInterface;
use _PhpScoperb75b35f52b74\Rector\Naming\Guard\DateTimeAtNamingConventionGuard;
use _PhpScoperb75b35f52b74\Rector\Naming\Guard\HasMagicGetSetGuard;
use _PhpScoperb75b35f52b74\Rector\Naming\Guard\NotPrivatePropertyGuard;
use _PhpScoperb75b35f52b74\Rector\Naming\Guard\RamseyUuidInterfaceGuard;
use _PhpScoperb75b35f52b74\Rector\Naming\RenameGuard\PropertyRenameGuard;
use _PhpScoperb75b35f52b74\Rector\Naming\ValueObject\PropertyRename;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
abstract class AbstractPropertyRenamer implements \_PhpScoperb75b35f52b74\Rector\Naming\Contract\RenamerInterface
{
    /**
     * @var RenameGuardInterface
     */
    protected $propertyRenameGuard;
    /**
     * @var ConflictingGuardInterface
     */
    protected $conflictingPropertyNameGuard;
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var NotPrivatePropertyGuard
     */
    private $notPrivatePropertyGuard;
    /**
     * @var RamseyUuidInterfaceGuard
     */
    private $ramseyUuidInterfaceGuard;
    /**
     * @var DateTimeAtNamingConventionGuard
     */
    private $dateTimeAtNamingConventionGuard;
    /**
     * @var HasMagicGetSetGuard
     */
    private $hasMagicGetSetGuard;
    /**
     * @required
     */
    public function autowireAbstractPropertyRenamer(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoperb75b35f52b74\Rector\Naming\Guard\NotPrivatePropertyGuard $notPrivatePropertyGuard, \_PhpScoperb75b35f52b74\Rector\Naming\Guard\RamseyUuidInterfaceGuard $ramseyUuidInterfaceGuard, \_PhpScoperb75b35f52b74\Rector\Naming\Guard\DateTimeAtNamingConventionGuard $dateTimeAtNamingConventionGuard, \_PhpScoperb75b35f52b74\Rector\Naming\RenameGuard\PropertyRenameGuard $propertyRenameGuard, \_PhpScoperb75b35f52b74\Rector\Naming\Guard\HasMagicGetSetGuard $hasMagicGetSetGuard) : void
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->notPrivatePropertyGuard = $notPrivatePropertyGuard;
        $this->ramseyUuidInterfaceGuard = $ramseyUuidInterfaceGuard;
        $this->dateTimeAtNamingConventionGuard = $dateTimeAtNamingConventionGuard;
        $this->propertyRenameGuard = $propertyRenameGuard;
        $this->hasMagicGetSetGuard = $hasMagicGetSetGuard;
    }
    /**
     * @param PropertyRename $renameValueObject
     * @return Property|null
     */
    public function rename(\_PhpScoperb75b35f52b74\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->areNamesDifferent($renameValueObject)) {
            return null;
        }
        if ($this->propertyRenameGuard->shouldSkip($renameValueObject, [$this->notPrivatePropertyGuard, $this->conflictingPropertyNameGuard, $this->ramseyUuidInterfaceGuard, $this->dateTimeAtNamingConventionGuard, $this->hasMagicGetSetGuard])) {
            return null;
        }
        $onlyPropertyProperty = $renameValueObject->getPropertyProperty();
        $onlyPropertyProperty->name = new \_PhpScoperb75b35f52b74\PhpParser\Node\VarLikeIdentifier($renameValueObject->getExpectedName());
        $this->renamePropertyFetchesInClass($renameValueObject);
        return $renameValueObject->getProperty();
    }
    private function areNamesDifferent(\_PhpScoperb75b35f52b74\Rector\Naming\ValueObject\PropertyRename $propertyRename) : bool
    {
        return $propertyRename->getCurrentName() !== $propertyRename->getExpectedName();
    }
    private function renamePropertyFetchesInClass(\_PhpScoperb75b35f52b74\Rector\Naming\ValueObject\PropertyRename $propertyRename) : void
    {
        // 1. replace property fetch rename in whole class
        $this->callableNodeTraverser->traverseNodesWithCallable($propertyRename->getClassLike(), function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use($propertyRename) : ?Node {
            if ($this->nodeNameResolver->isLocalPropertyFetchNamed($node, $propertyRename->getCurrentName()) && $node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch) {
                $node->name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier($propertyRename->getExpectedName());
                return $node;
            }
            if ($this->nodeNameResolver->isLocalStaticPropertyFetchNamed($node, $propertyRename->getCurrentName())) {
                if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticPropertyFetch) {
                    return null;
                }
                $node->name = new \_PhpScoperb75b35f52b74\PhpParser\Node\VarLikeIdentifier($propertyRename->getExpectedName());
                return $node;
            }
            return null;
        });
    }
}
