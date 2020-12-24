<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Nette\Rector\FuncCall;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticCall;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://spaceflow.io/ for sponsoring this rule - visit them on https://github.com/SpaceFlow-app
 *
 * @see \Rector\Nette\Tests\Rector\FuncCall\JsonDecodeEncodeToNetteUtilsJsonDecodeEncodeRector\JsonDecodeEncodeToNetteUtilsJsonDecodeEncodeRectorTest
 */
final class JsonDecodeEncodeToNetteUtilsJsonDecodeEncodeRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes json_encode()/json_decode() to safer and more verbose Nette\\Utils\\Json::encode()/decode() calls', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        if ($this->isName($node, 'json_encode')) {
            return $this->refactorJsonEncode($node);
        }
        if ($this->isName($node, 'json_decode')) {
            return $this->refactorJsonDecode($node);
        }
        return null;
    }
    private function refactorJsonEncode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $funcCall) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticCall
    {
        $args = $funcCall->args;
        if (isset($args[1])) {
            $secondArgumentValue = $args[1]->value;
            if ($this->isName($secondArgumentValue, 'JSON_PRETTY_PRINT')) {
                $classConstFetch = $this->createClassConstFetch('_PhpScoper2a4e7ab1ecbc\\Nette\\Utils\\Json', 'PRETTY');
                $args[1] = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg($classConstFetch);
            }
        }
        return $this->createStaticCall('_PhpScoper2a4e7ab1ecbc\\Nette\\Utils\\Json', 'encode', $args);
    }
    private function refactorJsonDecode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $funcCall) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticCall
    {
        $args = $funcCall->args;
        if (isset($args[1])) {
            $secondArgumentValue = $args[1]->value;
            if ($this->isFalse($secondArgumentValue)) {
                unset($args[1]);
            } elseif ($this->isTrue($secondArgumentValue)) {
                $classConstFetch = $this->createClassConstFetch('_PhpScoper2a4e7ab1ecbc\\Nette\\Utils\\Json', 'FORCE_ARRAY');
                $args[1] = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg($classConstFetch);
            }
        }
        return $this->createStaticCall('_PhpScoper2a4e7ab1ecbc\\Nette\\Utils\\Json', 'decode', $args);
    }
}
