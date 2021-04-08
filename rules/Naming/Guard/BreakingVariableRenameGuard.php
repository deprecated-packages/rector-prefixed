<?php

declare (strict_types=1);
namespace Rector\Naming\Guard;

use DateTimeInterface;
use RectorPrefix20210408\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\FunctionLike;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Foreach_;
use PhpParser\Node\Stmt\Function_;
use PhpParser\Node\Stmt\If_;
use PHPStan\Analyser\Scope;
use PHPStan\Type\ObjectType;
use PHPStan\Type\TypeWithClassName;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\Naming\Naming\ConflictingNameResolver;
use Rector\Naming\Naming\OverridenExistingNamesResolver;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\NodeTypeResolver;
use Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper;
/**
 * This class check if a variable name change breaks existing code in class method
 */
final class BreakingVariableRenameGuard
{
    /**
     * @var string
     * @see https://regex101.com/r/1pKLgf/1
     */
    private const AT_NAMING_REGEX = '#[\\w+]At$#';
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var ConflictingNameResolver
     */
    private $conflictingNameResolver;
    /**
     * @var OverridenExistingNamesResolver
     */
    private $overridenExistingNamesResolver;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var TypeUnwrapper
     */
    private $typeUnwrapper;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \Rector\Naming\Naming\ConflictingNameResolver $conflictingNameResolver, \Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \Rector\Naming\Naming\OverridenExistingNamesResolver $overridenExistingNamesResolver, \Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper $typeUnwrapper, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->conflictingNameResolver = $conflictingNameResolver;
        $this->overridenExistingNamesResolver = $overridenExistingNamesResolver;
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->typeUnwrapper = $typeUnwrapper;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @param ClassMethod|Function_|Closure $functionLike
     */
    public function shouldSkipVariable(string $currentName, string $expectedName, \PhpParser\Node\FunctionLike $functionLike, \PhpParser\Node\Expr\Variable $variable) : bool
    {
        // is the suffix? → also accepted
        if (\RectorPrefix20210408\Nette\Utils\Strings::endsWith($currentName, \ucfirst($expectedName))) {
            return \true;
        }
        if ($this->conflictingNameResolver->checkNameIsInFunctionLike($expectedName, $functionLike)) {
            return \true;
        }
        if ($this->overridenExistingNamesResolver->checkNameInClassMethodForNew($currentName, $functionLike)) {
            return \true;
        }
        if ($this->isVariableAlreadyDefined($variable, $currentName)) {
            return \true;
        }
        if ($this->skipOnConflictOtherVariable($functionLike, $expectedName)) {
            return \true;
        }
        if ($this->isUsedInClosureUsesName($expectedName, $functionLike)) {
            return \true;
        }
        if ($this->isUsedInForeachKeyValueVar($variable, $currentName)) {
            return \true;
        }
        return $this->isUsedInIfAndOtherBranches($variable, $currentName);
    }
    public function shouldSkipParam(string $currentName, string $expectedName, \PhpParser\Node\Stmt\ClassMethod $classMethod, \PhpParser\Node\Param $param) : bool
    {
        // is the suffix? → also accepted
        if (\RectorPrefix20210408\Nette\Utils\Strings::endsWith($currentName, \ucfirst($expectedName))) {
            return \true;
        }
        $conflictingNames = $this->conflictingNameResolver->resolveConflictingVariableNamesForParam($classMethod);
        if (\in_array($expectedName, $conflictingNames, \true)) {
            return \true;
        }
        if ($this->conflictingNameResolver->checkNameIsInFunctionLike($expectedName, $classMethod)) {
            return \true;
        }
        if ($this->overridenExistingNamesResolver->checkNameInClassMethodForParam($expectedName, $classMethod)) {
            return \true;
        }
        if ($this->isVariableAlreadyDefined($param->var, $currentName)) {
            return \true;
        }
        if ($this->isRamseyUuidInterface($param)) {
            return \true;
        }
        if ($this->isDateTimeAtNamingConvention($param)) {
            return \true;
        }
        return (bool) $this->betterNodeFinder->find((array) $classMethod->stmts, function (\PhpParser\Node $node) use($expectedName) : bool {
            if (!$node instanceof \PhpParser\Node\Expr\Variable) {
                return \false;
            }
            return $this->nodeNameResolver->isName($node, $expectedName);
        });
    }
    private function isVariableAlreadyDefined(\PhpParser\Node\Expr\Variable $variable, string $currentVariableName) : bool
    {
        $scope = $variable->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \PHPStan\Analyser\Scope) {
            return \false;
        }
        $trinaryLogic = $scope->hasVariableType($currentVariableName);
        if ($trinaryLogic->yes()) {
            return \true;
        }
        return $trinaryLogic->maybe();
    }
    /**
     * @param ClassMethod|Function_|Closure $functionLike
     */
    private function skipOnConflictOtherVariable(\PhpParser\Node\FunctionLike $functionLike, string $newName) : bool
    {
        return $this->betterNodeFinder->hasInstanceOfName((array) $functionLike->stmts, \PhpParser\Node\Expr\Variable::class, $newName);
    }
    /**
     * @param ClassMethod|Function_|Closure $functionLike
     */
    private function isUsedInClosureUsesName(string $expectedName, \PhpParser\Node\FunctionLike $functionLike) : bool
    {
        if (!$functionLike instanceof \PhpParser\Node\Expr\Closure) {
            return \false;
        }
        return $this->betterNodeFinder->hasVariableOfName($functionLike->uses, $expectedName);
    }
    private function isUsedInForeachKeyValueVar(\PhpParser\Node\Expr\Variable $variable, string $currentName) : bool
    {
        $previousForeach = $this->betterNodeFinder->findFirstPreviousOfTypes($variable, [\PhpParser\Node\Stmt\Foreach_::class]);
        if ($previousForeach instanceof \PhpParser\Node\Stmt\Foreach_) {
            if ($previousForeach->keyVar === $variable) {
                return \false;
            }
            if ($previousForeach->valueVar === $variable) {
                return \false;
            }
            if ($this->nodeNameResolver->isName($previousForeach->valueVar, $currentName)) {
                return \true;
            }
            if ($previousForeach->keyVar === null) {
                return \false;
            }
            if ($this->nodeNameResolver->isName($previousForeach->keyVar, $currentName)) {
                return \true;
            }
        }
        return \false;
    }
    private function isUsedInIfAndOtherBranches(\PhpParser\Node\Expr\Variable $variable, string $currentVariableName) : bool
    {
        // is in if branches?
        $previousIf = $this->betterNodeFinder->findFirstPreviousOfTypes($variable, [\PhpParser\Node\Stmt\If_::class]);
        if ($previousIf instanceof \PhpParser\Node\Stmt\If_) {
            $variableUses = [];
            $variableUses[] = $this->betterNodeFinder->findVariableOfName($previousIf->stmts, $currentVariableName);
            $previousStmts = $previousIf->else !== null ? $previousIf->else->stmts : [];
            $variableUses[] = $this->betterNodeFinder->findVariableOfName($previousStmts, $currentVariableName);
            $variableUses[] = $this->betterNodeFinder->findVariableOfName($previousIf->elseifs, $currentVariableName);
            $variableUses = \array_filter($variableUses);
            if (\count($variableUses) > 1) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @TODO Remove once ParamRenamer created
     */
    private function isRamseyUuidInterface(\PhpParser\Node\Param $param) : bool
    {
        return $this->nodeTypeResolver->isObjectType($param, new \PHPStan\Type\ObjectType('Ramsey\\Uuid\\UuidInterface'));
    }
    /**
     * @TODO Remove once ParamRenamer created
     */
    private function isDateTimeAtNamingConvention(\PhpParser\Node\Param $param) : bool
    {
        $type = $this->nodeTypeResolver->resolve($param);
        $type = $this->typeUnwrapper->unwrapFirstObjectTypeFromUnionType($type);
        if (!$type instanceof \PHPStan\Type\TypeWithClassName) {
            return \false;
        }
        if (!\is_a($type->getClassName(), \DateTimeInterface::class, \true)) {
            return \false;
        }
        /** @var string $currentName */
        $currentName = $this->nodeNameResolver->getName($param);
        return (bool) \RectorPrefix20210408\Nette\Utils\Strings::match($currentName, self::AT_NAMING_REGEX . '');
    }
}
