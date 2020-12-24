<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample;

use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\AbstractCodeSample;
final class ExtraFileCodeSample extends \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\AbstractCodeSample
{
    /**
     * @var string
     */
    private $extraFile;
    public function __construct(string $badCode, string $goodCode, string $extraFile)
    {
        parent::__construct($badCode, $goodCode);
        $this->extraFile = $extraFile;
    }
    public function getExtraFile() : string
    {
        return $this->extraFile;
    }
}
