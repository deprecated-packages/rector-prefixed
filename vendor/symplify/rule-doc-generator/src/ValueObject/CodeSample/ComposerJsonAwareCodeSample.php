<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample;

use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\AbstractCodeSample;
final class ComposerJsonAwareCodeSample extends \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\AbstractCodeSample
{
    /**
     * @var string
     */
    private $composerJson;
    public function __construct(string $badCode, string $goodCode, string $composerJson)
    {
        parent::__construct($badCode, $goodCode);
        $this->composerJson = $composerJson;
    }
    public function getComposerJson() : string
    {
        return $this->composerJson;
    }
}
