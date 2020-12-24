<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Classes;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Php\PhpVersion;
use _PhpScoperb75b35f52b74\PHPStan\Rules\Rule;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements Rule<Node>
 */
class InvalidPromotedPropertiesRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    /** @var PhpVersion */
    private $phpVersion;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Php\PhpVersion $phpVersion)
    {
        $this->phpVersion = $phpVersion;
    }
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrowFunction && !$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod && !$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Closure && !$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Function_) {
            return [];
        }
        $hasPromotedProperties = \false;
        foreach ($node->params as $param) {
            if ($param->flags === 0) {
                continue;
            }
            $hasPromotedProperties = \true;
            break;
        }
        if (!$hasPromotedProperties) {
            return [];
        }
        if (!$this->phpVersion->supportsPromotedProperties()) {
            return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message('Promoted properties are supported only on PHP 8.0 and later.')->nonIgnorable()->build()];
        }
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod || $node->name->toLowerString() !== '__construct') {
            return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message('Promoted properties can be in constructor only.')->nonIgnorable()->build()];
        }
        if ($node->stmts === null) {
            return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message('Promoted properties are not allowed in abstract constructors.')->nonIgnorable()->build()];
        }
        $errors = [];
        foreach ($node->params as $param) {
            if ($param->flags === 0) {
                continue;
            }
            if (!$param->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable || !\is_string($param->var->name)) {
                throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
            }
            if (!$param->variadic) {
                continue;
            }
            $propertyName = $param->var->name;
            $errors[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Promoted property parameter $%s can not be variadic.', $propertyName))->nonIgnorable()->line($param->getLine())->build();
            continue;
        }
        return $errors;
    }
}
