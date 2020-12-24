<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\CakePHP\Rector\MethodCall;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier;
use _PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\RenameMethodCallBasedOnParameter;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoper2a4e7ab1ecbc\Webmozart\Assert\Assert;
/**
 * @see https://book.cakephp.org/4.0/en/appendices/4-0-migration-guide.html
 * @see https://github.com/cakephp/cakephp/commit/77017145961bb697b4256040b947029259f66a9b
 *
 * @see \Rector\CakePHP\Tests\Rector\MethodCall\RenameMethodCallBasedOnParameterRector\RenameMethodCallBasedOnParameterRectorTest
 */
final class RenameMethodCallBasedOnParameterRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector implements \_PhpScoper2a4e7ab1ecbc\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const CALLS_WITH_PARAM_RENAMES = 'calls_with_param_renames';
    /**
     * @var RenameMethodCallBasedOnParameter[]
     */
    private $callsWithParamRenames = [];
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        $configuration = [self::CALLS_WITH_PARAM_RENAMES => [new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\RenameMethodCallBasedOnParameter('ServerRequest', 'getParam', 'paging', 'getAttribute'), new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\RenameMethodCallBasedOnParameter('ServerRequest', 'withParam', 'paging', 'withAttribute')]];
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes method calls based on matching the first parameter value.', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
$object = new ServerRequest();

$config = $object->getParam('paging');
$object = $object->withParam('paging', ['a value']);
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$object = new ServerRequest();

$config = $object->getAttribute('paging');
$object = $object->withAttribute('paging', ['a value']);
CODE_SAMPLE
, $configuration)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        $callWithParamRename = $this->matchTypeAndMethodName($node);
        if ($callWithParamRename === null) {
            return null;
        }
        $node->name = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier($callWithParamRename->getNewMethod());
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $callsWithParamNames = $configuration[self::CALLS_WITH_PARAM_RENAMES] ?? [];
        \_PhpScoper2a4e7ab1ecbc\Webmozart\Assert\Assert::allIsInstanceOf($callsWithParamNames, \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\RenameMethodCallBasedOnParameter::class);
        $this->callsWithParamRenames = $callsWithParamNames;
    }
    private function matchTypeAndMethodName(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\RenameMethodCallBasedOnParameter
    {
        foreach ($this->callsWithParamRenames as $callWithParamRename) {
            if (!$this->isObjectType($methodCall, $callWithParamRename->getOldClass())) {
                continue;
            }
            if (!$this->isName($methodCall->name, $callWithParamRename->getOldMethod())) {
                continue;
            }
            if (\count((array) $methodCall->args) < 1) {
                continue;
            }
            $arg = $methodCall->args[0];
            if (!$this->isValue($arg->value, $callWithParamRename->getParameterName())) {
                continue;
            }
            return $callWithParamRename;
        }
        return null;
    }
}
