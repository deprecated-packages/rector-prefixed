<?php

declare (strict_types=1);
namespace Symplify\RuleDocGenerator\ValueObject\CodeSample;

use Symplify\RuleDocGenerator\Contract\CodeSampleInterface;
use Symplify\RuleDocGenerator\ValueObject\AbstractCodeSample;
final class ConfiguredCodeSample extends \Symplify\RuleDocGenerator\ValueObject\AbstractCodeSample implements \Symplify\RuleDocGenerator\Contract\CodeSampleInterface
{
    /**
     * @var array<string, mixed>
     */
    private $configuration = [];
    /**
     * @param array<string, mixed> $configuration
     */
    public function __construct(string $goodCode, string $badCode, array $configuration)
    {
        $this->configuration = $configuration;
        parent::__construct($goodCode, $badCode);
    }
    /**
     * @return array<string, mixed>
     */
    public function getConfiguration() : array
    {
        return $this->configuration;
    }
}
