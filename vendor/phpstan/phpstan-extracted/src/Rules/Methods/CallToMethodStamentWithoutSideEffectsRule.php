<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Methods;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Rules\Rule;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleLevelHelper;
use _PhpScoper0a6b37af0871\PHPStan\Type\ErrorType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Expression>
 */
class CallToMethodStamentWithoutSideEffectsRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        if ($node->expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\NullsafeMethodCall) {
            $scope = $scope->filterByTruthyValue(new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotIdentical($node->expr->var, new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ConstFetch(new \_PhpScoper0a6b37af0871\PhpParser\Node\Name('null'))));
        } elseif (!$node->expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
            return [];
        }
        $methodCall = $node->expr;
        if (!$methodCall->name instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Identifier) {
            return [];
        }
        $methodName = $methodCall->name->toString();
        $typeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $methodCall->var, '', static function (\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) use($methodName) : bool {
            return $type->canCallMethods()->yes() && $type->hasMethod($methodName)->yes();
        });
        $calledOnType = $typeResult->getType();
        if ($calledOnType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ErrorType) {
            return [];
        }
        if (!$calledOnType->canCallMethods()->yes()) {
            return [];
        }
        if (!$calledOnType->hasMethod($methodName)->yes()) {
            return [];
        }
        $method = $calledOnType->getMethod($methodName, $scope);
        if ($method->hasSideEffects()->no()) {
            return [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to %s %s::%s() on a separate line has no effect.', $method->isStatic() ? 'static method' : 'method', $method->getDeclaringClass()->getDisplayName(), $method->getName()))->build()];
        }
        return [];
    }
}
