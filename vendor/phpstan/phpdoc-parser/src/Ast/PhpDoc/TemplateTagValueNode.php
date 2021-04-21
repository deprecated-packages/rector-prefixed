<?php declare(strict_types = 1);

namespace PHPStan\PhpDocParser\Ast\PhpDoc;

use PHPStan\PhpDocParser\Ast\NodeAttributes;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;

class TemplateTagValueNode implements PhpDocTagValueNode
{

	use NodeAttributes;

	/** @var string */
	public $name;

	/** @var TypeNode|null */
	public $bound;

	/** @var string (may be empty) */
	public $description;

	/**
	 * @param \PHPStan\PhpDocParser\Ast\Type\TypeNode|null $bound
	 */
	public function __construct(string $name, $bound, string $description)
	{
		$this->name = $name;
		$this->bound = $bound;
		$this->description = $description;
	}


	public function __toString(): string
	{
		$bound = $this->bound !== null ? " of {$this->bound}" : '';
		return trim("{$this->name}{$bound} {$this->description}");
	}

}
