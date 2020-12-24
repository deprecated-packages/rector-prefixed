<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer;

use _PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use _PhpScopere8e811afab72\Rector\StaticTypeMapper\StaticTypeMapper;
abstract class AbstractTypeInferer
{
    /**
     * @var CallableNodeTraverser
     */
    protected $callableNodeTraverser;
    /**
     * @var NodeNameResolver
     */
    protected $nodeNameResolver;
    /**
     * @var NodeTypeResolver
     */
    protected $nodeTypeResolver;
    /**
     * @var StaticTypeMapper
     */
    protected $staticTypeMapper;
    /**
     * @var TypeFactory
     */
    protected $typeFactory;
    /**
     * @required
     */
    public function autowireAbstractTypeInferer(\_PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScopere8e811afab72\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory) : void
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->staticTypeMapper = $staticTypeMapper;
        $this->typeFactory = $typeFactory;
    }
}
