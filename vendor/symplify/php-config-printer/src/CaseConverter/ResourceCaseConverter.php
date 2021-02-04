<?php

declare (strict_types=1);
namespace RectorPrefix20210204\Symplify\PhpConfigPrinter\CaseConverter;

use PhpParser\Node\Stmt\Expression;
use RectorPrefix20210204\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use RectorPrefix20210204\Symplify\PhpConfigPrinter\NodeFactory\Service\ServicesPhpNodeFactory;
use RectorPrefix20210204\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
/**
 * Handles this part:
 *
 * services:
 *     App\\: <--
 *          source: '../src'
 */
final class ResourceCaseConverter implements \RectorPrefix20210204\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @var ServicesPhpNodeFactory
     */
    private $servicesPhpNodeFactory;
    public function __construct(\RectorPrefix20210204\Symplify\PhpConfigPrinter\NodeFactory\Service\ServicesPhpNodeFactory $servicesPhpNodeFactory)
    {
        $this->servicesPhpNodeFactory = $servicesPhpNodeFactory;
    }
    public function convertToMethodCall($key, $values) : \PhpParser\Node\Stmt\Expression
    {
        // Due to the yaml behavior that does not allow the declaration of several identical key names.
        if (isset($values['namespace'])) {
            $key = $values['namespace'];
            unset($values['namespace']);
        }
        return $this->servicesPhpNodeFactory->createResource($key, $values);
    }
    public function match(string $rootKey, $key, $values) : bool
    {
        return isset($values[\RectorPrefix20210204\Symplify\PhpConfigPrinter\ValueObject\YamlKey::RESOURCE]);
    }
}
