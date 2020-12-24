<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample;

use _PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\Configuration\InvalidConfigurationException;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\Contract\CodeSampleInterface;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\AbstractCodeSample;
final class ConfiguredCodeSample extends \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\AbstractCodeSample implements \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\Contract\CodeSampleInterface
{
    /**
     * @var array<string, mixed>
     */
    private $configuration = [];
    /**
     * @param array<string, mixed> $configuration
     */
    public function __construct(string $badCode, string $goodCode, array $configuration)
    {
        if ($configuration === []) {
            throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\Configuration\InvalidConfigurationException('Configuration cannot be empty');
        }
        $this->configuration = $configuration;
        parent::__construct($badCode, $goodCode);
    }
    /**
     * @return array<string, mixed>
     */
    public function getConfiguration() : array
    {
        return $this->configuration;
    }
}
