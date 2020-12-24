<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Methods;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Rules\Rule;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleLevelHelper;
use _PhpScoperb75b35f52b74\PHPStan\Type\ErrorType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Expression>
 */
class CallToMethodStamentWithoutSideEffectsRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        if ($node->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\NullsafeMethodCall) {
            $scope = $scope->filterByTruthyValue(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotIdentical($node->expr->var, new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ConstFetch(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name('null'))));
        } elseif (!$node->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
            return [];
        }
        $methodCall = $node->expr;
        if (!$methodCall->name instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier) {
            return [];
        }
        $methodName = $methodCall->name->toString();
        $typeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $methodCall->var, '', static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) use($methodName) : bool {
            return $type->canCallMethods()->yes() && $type->hasMethod($methodName)->yes();
        });
        $calledOnType = $typeResult->getType();
        if ($calledOnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType) {
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
            return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to %s %s::%s() on a separate line has no effect.', $method->isStatic() ? 'static method' : 'method', $method->getDeclaringClass()->getDisplayName(), $method->getName()))->build()];
        }
        return [];
    }
}
