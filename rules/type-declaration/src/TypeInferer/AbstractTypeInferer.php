<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\TypeInferer;

use Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\NodeTypeResolver;
use Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use Rector\StaticTypeMapper\StaticTypeMapper;
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
    public function autowireAbstractTypeInferer(\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory) : void
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->staticTypeMapper = $staticTypeMapper;
        $this->typeFactory = $typeFactory;
    }
}
