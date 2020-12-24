<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample;

use _PhpScopere8e811afab72\Rector\Core\Exception\Configuration\InvalidConfigurationException;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\Contract\CodeSampleInterface;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\AbstractCodeSample;
final class ConfiguredCodeSample extends \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\AbstractCodeSample implements \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\Contract\CodeSampleInterface
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
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\Configuration\InvalidConfigurationException('Configuration cannot be empty');
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
