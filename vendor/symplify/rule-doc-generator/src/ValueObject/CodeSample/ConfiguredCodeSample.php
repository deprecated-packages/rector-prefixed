<?php

declare (strict_types=1);
namespace RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample;

use Rector\Core\Exception\Configuration\InvalidConfigurationException;
use RectorPrefix20201228\Symplify\RuleDocGenerator\Contract\CodeSampleInterface;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\AbstractCodeSample;
final class ConfiguredCodeSample extends \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\AbstractCodeSample implements \RectorPrefix20201228\Symplify\RuleDocGenerator\Contract\CodeSampleInterface
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
            throw new \Rector\Core\Exception\Configuration\InvalidConfigurationException('Configuration cannot be empty');
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
