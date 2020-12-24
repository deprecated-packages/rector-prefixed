<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample;

use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\AbstractCodeSample;
final class ExtraFileCodeSample extends \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\AbstractCodeSample
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
