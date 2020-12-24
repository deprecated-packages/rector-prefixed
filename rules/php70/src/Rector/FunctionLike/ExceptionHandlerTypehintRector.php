<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php70\Rector\FunctionLike;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PhpParser\Node\NullableType;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://wiki.php.net/rfc/typed_properties_v2#proposal
 *
 * @see \Rector\Php70\Tests\Rector\FunctionLike\ExceptionHandlerTypehintRector\ExceptionHandlerTypehintRectorTest
 */
final class ExceptionHandlerTypehintRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     * @see https://regex101.com/r/VBFXCR/1
     */
    private const HANDLE_INSENSITIVE_REGEX = '#handle#i';
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes property `@var` annotations from annotation to type.', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
function handler(Exception $exception) { ... }
set_exception_handler('handler');
CODE_SAMPLE
, <<<'CODE_SAMPLE'
function handler(Throwable $exception) { ... }
set_exception_handler('handler');
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param Function_|ClassMethod $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isAtLeastPhpVersion(\_PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature::THROWABLE_TYPE)) {
            return null;
        }
        // exception handle has 1 param exactly
        if (\count((array) $node->params) !== 1) {
            return null;
        }
        $paramNode = $node->params[0];
        if ($paramNode->type === null) {
            return null;
        }
        // handle only Exception typehint
        $actualType = $paramNode->type instanceof \_PhpScopere8e811afab72\PhpParser\Node\NullableType ? $this->getName($paramNode->type->type) : $this->getName($paramNode->type);
        if ($actualType !== 'Exception') {
            return null;
        }
        // is probably handling exceptions
        if (!\_PhpScopere8e811afab72\Nette\Utils\Strings::match((string) $node->name, self::HANDLE_INSENSITIVE_REGEX)) {
            return null;
        }
        if (!$paramNode->type instanceof \_PhpScopere8e811afab72\PhpParser\Node\NullableType) {
            $paramNode->type = new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified('Throwable');
        } else {
            $paramNode->type->type = new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified('Throwable');
        }
        return $node;
    }
}
