<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming\Guard;

use DateTimeInterface;
use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Closure;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\If_;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName;
use _PhpScopere8e811afab72\Ramsey\Uuid\UuidInterface;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScopere8e811afab72\Rector\Naming\Naming\ConflictingNameResolver;
use _PhpScopere8e811afab72\Rector\Naming\Naming\OverridenExistingNamesResolver;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper;
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
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScopere8e811afab72\Rector\Naming\Naming\ConflictingNameResolver $conflictingNameResolver, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScopere8e811afab72\Rector\Naming\Naming\OverridenExistingNamesResolver $overridenExistingNamesResolver, \_PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper $typeUnwrapper, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
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
    public function shouldSkipVariable(string $currentName, string $expectedName, \_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $functionLike, \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable $variable) : bool
    {
        // is the suffix? → also accepted
        if (\_PhpScopere8e811afab72\Nette\Utils\Strings::endsWith($currentName, \ucfirst($expectedName))) {
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
    public function shouldSkipParam(string $currentName, string $expectedName, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScopere8e811afab72\PhpParser\Node\Param $param) : bool
    {
        // is the suffix? → also accepted
        if (\_PhpScopere8e811afab72\Nette\Utils\Strings::endsWith($currentName, \ucfirst($expectedName))) {
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
        return $this->isDateTimeAtNamingConvention($param);
    }
    private function isVariableAlreadyDefined(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable $variable, string $currentVariableName) : bool
    {
        $scope = $variable->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \_PhpScopere8e811afab72\PHPStan\Analyser\Scope) {
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
    private function skipOnConflictOtherVariable(\_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $functionLike, string $newName) : bool
    {
        return $this->betterNodeFinder->hasInstanceOfName((array) $functionLike->stmts, \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable::class, $newName);
    }
    /**
     * @param ClassMethod|Function_|Closure $functionLike
     */
    private function isUsedInClosureUsesName(string $expectedName, \_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $functionLike) : bool
    {
        if (!$functionLike instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Closure) {
            return \false;
        }
        return $this->betterNodeFinder->hasVariableOfName((array) $functionLike->uses, $expectedName);
    }
    private function isUsedInForeachKeyValueVar(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable $variable, string $currentName) : bool
    {
        $previousForeach = $this->betterNodeFinder->findFirstPreviousOfTypes($variable, [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_::class]);
        if ($previousForeach instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_) {
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
    private function isUsedInIfAndOtherBranches(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable $variable, string $currentVariableName) : bool
    {
        // is in if branches?
        $previousIf = $this->betterNodeFinder->findFirstPreviousOfTypes($variable, [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\If_::class]);
        if ($previousIf instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\If_) {
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
    private function isRamseyUuidInterface(\_PhpScopere8e811afab72\PhpParser\Node\Param $param) : bool
    {
        return $this->nodeTypeResolver->isObjectType($param, \_PhpScopere8e811afab72\Ramsey\Uuid\UuidInterface::class);
    }
    /**
     * @TODO Remove once ParamRenamer created
     */
    private function isDateTimeAtNamingConvention(\_PhpScopere8e811afab72\PhpParser\Node\Param $param) : bool
    {
        $type = $this->nodeTypeResolver->resolve($param);
        $type = $this->typeUnwrapper->unwrapFirstObjectTypeFromUnionType($type);
        if (!$type instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName) {
            return \false;
        }
        if (!\is_a($type->getClassName(), \DateTimeInterface::class, \true)) {
            return \false;
        }
        /** @var string $currentName */
        $currentName = $this->nodeNameResolver->getName($param);
        return (bool) \_PhpScopere8e811afab72\Nette\Utils\Strings::match($currentName, self::AT_NAMING_REGEX . '');
    }
}
