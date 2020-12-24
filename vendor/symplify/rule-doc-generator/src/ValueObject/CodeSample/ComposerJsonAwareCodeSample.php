<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample;

use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\AbstractCodeSample;
final class ComposerJsonAwareCodeSample extends \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\AbstractCodeSample
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
