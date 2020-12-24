<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Nette\Rector\FuncCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://spaceflow.io/ for sponsoring this rule - visit them on https://github.com/SpaceFlow-app
 *
 * @see \Rector\Nette\Tests\Rector\FuncCall\JsonDecodeEncodeToNetteUtilsJsonDecodeEncodeRector\JsonDecodeEncodeToNetteUtilsJsonDecodeEncodeRectorTest
 */
final class JsonDecodeEncodeToNetteUtilsJsonDecodeEncodeRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes json_encode()/json_decode() to safer and more verbose Nette\\Utils\\Json::encode()/decode() calls', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function decodeJson(string $jsonString)
    {
        $stdClass = json_decode($jsonString);

        $array = json_decode($jsonString, true);
        $array = json_decode($jsonString, false);
    }

    public function encodeJson(array $data)
    {
        $jsonString = json_encode($data);

        $prettyJsonString = json_encode($data, JSON_PRETTY_PRINT);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function decodeJson(string $jsonString)
    {
        $stdClass = \Nette\Utils\Json::decode($jsonString);

        $array = \Nette\Utils\Json::decode($jsonString, \Nette\Utils\Json::FORCE_ARRAY);
        $array = \Nette\Utils\Json::decode($jsonString);
    }

    public function encodeJson(array $data)
    {
        $jsonString = \Nette\Utils\Json::encode($data);

        $prettyJsonString = \Nette\Utils\Json::encode($data, \Nette\Utils\Json::PRETTY);
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($this->isName($node, 'json_encode')) {
            return $this->refactorJsonEncode($node);
        }
        if ($this->isName($node, 'json_decode')) {
            return $this->refactorJsonDecode($node);
        }
        return null;
    }
    private function refactorJsonEncode(\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $funcCall) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall
    {
        $args = $funcCall->args;
        if (isset($args[1])) {
            $secondArgumentValue = $args[1]->value;
            if ($this->isName($secondArgumentValue, 'JSON_PRETTY_PRINT')) {
                $classConstFetch = $this->createClassConstFetch('_PhpScopere8e811afab72\\Nette\\Utils\\Json', 'PRETTY');
                $args[1] = new \_PhpScopere8e811afab72\PhpParser\Node\Arg($classConstFetch);
            }
        }
        return $this->createStaticCall('_PhpScopere8e811afab72\\Nette\\Utils\\Json', 'encode', $args);
    }
    private function refactorJsonDecode(\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $funcCall) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall
    {
        $args = $funcCall->args;
        if (isset($args[1])) {
            $secondArgumentValue = $args[1]->value;
            if ($this->isFalse($secondArgumentValue)) {
                unset($args[1]);
            } elseif ($this->isTrue($secondArgumentValue)) {
                $classConstFetch = $this->createClassConstFetch('_PhpScopere8e811afab72\\Nette\\Utils\\Json', 'FORCE_ARRAY');
                $args[1] = new \_PhpScopere8e811afab72\PhpParser\Node\Arg($classConstFetch);
            }
        }
        return $this->createStaticCall('_PhpScopere8e811afab72\\Nette\\Utils\\Json', 'decode', $args);
    }
}
