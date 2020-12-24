<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject;

use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Contract\CodeSampleInterface;
use _PhpScoperb75b35f52b74\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
abstract class AbstractCodeSample implements \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Contract\CodeSampleInterface
{
    /**
     * @var string
     */
    private $goodCode;
    /**
     * @var string
     */
    private $badCode;
    public function __construct(string $badCode, string $goodCode)
    {
        if ($badCode === '') {
            throw new \_PhpScoperb75b35f52b74\Symplify\SymplifyKernel\Exception\ShouldNotHappenException('Bad sample good code cannot be empty');
        }
        if ($goodCode === $badCode) {
            $errorMessage = \sprintf('Good and bad code cannot be identical: "%s"', $goodCode);
            throw new \_PhpScoperb75b35f52b74\Symplify\SymplifyKernel\Exception\ShouldNotHappenException($errorMessage);
        }
        $this->goodCode = $goodCode;
        $this->badCode = $badCode;
    }
    public function getGoodCode() : string
    {
        return $this->goodCode;
    }
    public function getBadCode() : string
    {
        return $this->badCode;
    }
}
