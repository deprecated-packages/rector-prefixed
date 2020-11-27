<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Roave\BetterReflection\TypesFinder;

use LogicException;
use _PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\DocBlock\Tags\Param;
use _PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\DocBlockFactory;
use _PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\Type;
use PhpParser\Node\Expr\Error;
use PhpParser\Node\Param as ParamNode;
use PhpParser\Node\Stmt\Namespace_;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\ReflectionFunctionAbstract;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\TypesFinder\PhpDocumentor\NamespaceNodeToReflectionTypeContext;
use function explode;
class FindParameterType
{
    /** @var ResolveTypes */
    private $resolveTypes;
    /** @var DocBlockFactory */
    private $docBlockFactory;
    /** @var NamespaceNodeToReflectionTypeContext */
    private $makeContext;
    public function __construct()
    {
        $this->resolveTypes = new \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\TypesFinder\ResolveTypes();
        $this->docBlockFactory = \_PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\DocBlockFactory::createInstance();
        $this->makeContext = new \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\TypesFinder\PhpDocumentor\NamespaceNodeToReflectionTypeContext();
    }
    /**
     * Given a function and parameter, attempt to find the type of the parameter.
     *
     * @return Type[]
     */
    public function __invoke(\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\ReflectionFunctionAbstract $function, ?\PhpParser\Node\Stmt\Namespace_ $namespace, \PhpParser\Node\Param $node) : array
    {
        $docComment = $function->getDocComment();
        if ($docComment === '') {
            return [];
        }
        $context = $this->makeContext->__invoke($namespace);
        /** @var Param[] $paramTags */
        $paramTags = $this->docBlockFactory->create($docComment, $context)->getTagsByName('param');
        foreach ($paramTags as $paramTag) {
            if ($node->var instanceof \PhpParser\Node\Expr\Error) {
                throw new \LogicException('PhpParser left an "Error" node in the parameters AST, this should NOT happen');
            }
            if ($paramTag->getVariableName() === $node->var->name) {
                return $this->resolveTypes->__invoke(\explode('|', (string) $paramTag->getType()), $context);
            }
        }
        return [];
    }
}
