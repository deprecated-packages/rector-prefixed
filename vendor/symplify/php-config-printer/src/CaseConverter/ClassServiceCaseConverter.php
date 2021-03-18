<?php

declare (strict_types=1);
namespace RectorPrefix20210318\Symplify\PhpConfigPrinter\CaseConverter;

use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Expression;
use RectorPrefix20210318\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use RectorPrefix20210318\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use RectorPrefix20210318\Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory;
use RectorPrefix20210318\Symplify\PhpConfigPrinter\ValueObject\MethodName;
use RectorPrefix20210318\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use RectorPrefix20210318\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ClassServiceCaseConverter implements \RectorPrefix20210318\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @var ArgsNodeFactory
     */
    private $argsNodeFactory;
    /**
     * @var ServiceOptionNodeFactory
     */
    private $serviceOptionNodeFactory;
    public function __construct(\RectorPrefix20210318\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory, \RectorPrefix20210318\Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory $serviceOptionNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
        $this->serviceOptionNodeFactory = $serviceOptionNodeFactory;
    }
    public function convertToMethodCall($key, $values) : \PhpParser\Node\Stmt\Expression
    {
        $args = $this->argsNodeFactory->createFromValues([$key, $values[\RectorPrefix20210318\Symplify\PhpConfigPrinter\ValueObject\YamlKey::CLASS_KEY]]);
        $setMethodCall = new \PhpParser\Node\Expr\MethodCall(new \PhpParser\Node\Expr\Variable(\RectorPrefix20210318\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES), \RectorPrefix20210318\Symplify\PhpConfigPrinter\ValueObject\MethodName::SET, $args);
        unset($values[\RectorPrefix20210318\Symplify\PhpConfigPrinter\ValueObject\YamlKey::CLASS_KEY]);
        $setMethodCall = $this->serviceOptionNodeFactory->convertServiceOptionsToNodes($values, $setMethodCall);
        return new \PhpParser\Node\Stmt\Expression($setMethodCall);
    }
    public function match(string $rootKey, $key, $values) : bool
    {
        if ($rootKey !== \RectorPrefix20210318\Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            return \false;
        }
        if (\is_array($values) && \count($values) !== 1) {
            return \false;
        }
        if (!isset($values[\RectorPrefix20210318\Symplify\PhpConfigPrinter\ValueObject\YamlKey::CLASS_KEY])) {
            return \false;
        }
        return !isset($values[\RectorPrefix20210318\Symplify\PhpConfigPrinter\ValueObject\YamlKey::ALIAS]);
    }
}
