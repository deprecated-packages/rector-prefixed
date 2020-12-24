<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample;

use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\AbstractCodeSample;
final class ExtraFileCodeSample extends \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\AbstractCodeSample
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
