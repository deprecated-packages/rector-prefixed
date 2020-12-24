<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Naming\Guard;

use DateTimeInterface;
use _PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Closure;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\FunctionLike;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Foreach_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Function_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\If_;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeWithClassName;
use _PhpScoper2a4e7ab1ecbc\Ramsey\Uuid\UuidInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\Naming\ConflictingNameResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\Naming\OverridenExistingNamesResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper;
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoper2a4e7ab1ecbc\Rector\Naming\Naming\ConflictingNameResolver $conflictingNameResolver, \_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScoper2a4e7ab1ecbc\Rector\Naming\Naming\OverridenExistingNamesResolver $overridenExistingNamesResolver, \_PhpScoper2a4e7ab1ecbc\Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper $typeUnwrapper, \_PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
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
    public function shouldSkipVariable(string $currentName, string $expectedName, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\FunctionLike $functionLike, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable $variable) : bool
    {
        // is the suffix? → also accepted
        if (\_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::endsWith($currentName, \ucfirst($expectedName))) {
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
    public function shouldSkipParam(string $currentName, string $expectedName, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param $param) : bool
    {
        // is the suffix? → also accepted
        if (\_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::endsWith($currentName, \ucfirst($expectedName))) {
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
    private function isVariableAlreadyDefined(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable $variable, string $currentVariableName) : bool
    {
        $scope = $variable->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope) {
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
    private function skipOnConflictOtherVariable(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\FunctionLike $functionLike, string $newName) : bool
    {
        return $this->betterNodeFinder->hasInstanceOfName((array) $functionLike->stmts, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable::class, $newName);
    }
    /**
     * @param ClassMethod|Function_|Closure $functionLike
     */
    private function isUsedInClosureUsesName(string $expectedName, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\FunctionLike $functionLike) : bool
    {
        if (!$functionLike instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Closure) {
            return \false;
        }
        return $this->betterNodeFinder->hasVariableOfName((array) $functionLike->uses, $expectedName);
    }
    private function isUsedInForeachKeyValueVar(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable $variable, string $currentName) : bool
    {
        $previousForeach = $this->betterNodeFinder->findFirstPreviousOfTypes($variable, [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Foreach_::class]);
        if ($previousForeach instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Foreach_) {
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
    private function isUsedInIfAndOtherBranches(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable $variable, string $currentVariableName) : bool
    {
        // is in if branches?
        $previousIf = $this->betterNodeFinder->findFirstPreviousOfTypes($variable, [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\If_::class]);
        if ($previousIf instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\If_) {
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
    private function isRamseyUuidInterface(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param $param) : bool
    {
        return $this->nodeTypeResolver->isObjectType($param, \_PhpScoper2a4e7ab1ecbc\Ramsey\Uuid\UuidInterface::class);
    }
    /**
     * @TODO Remove once ParamRenamer created
     */
    private function isDateTimeAtNamingConvention(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param $param) : bool
    {
        $type = $this->nodeTypeResolver->resolve($param);
        $type = $this->typeUnwrapper->unwrapFirstObjectTypeFromUnionType($type);
        if (!$type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeWithClassName) {
            return \false;
        }
        if (!\is_a($type->getClassName(), \DateTimeInterface::class, \true)) {
            return \false;
        }
        /** @var string $currentName */
        $currentName = $this->nodeNameResolver->getName($param);
        return (bool) \_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::match($currentName, self::AT_NAMING_REGEX . '');
    }
}
