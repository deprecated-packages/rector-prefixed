<?php

namespace _PhpScoper006a73f0e455\Bug2676ReturnTypeRule;

use _PhpScoper006a73f0e455\DoctrineIntersectionTypeIsSupertypeOf\Collection;
class BankAccount
{
}
/**
 * @ORM\Table
 * @ORM\Entity
 */
class Wallet
{
    /**
     * @var Collection<BankAccount>
     *
     * @ORM\OneToMany(targetEntity=BankAccount::class, mappedBy="wallet")
     * @ORM\OrderBy({"id" = "ASC"})
     */
    private $bankAccountList;
    /**
     * @return Collection<BankAccount>
     */
    public function getBankAccountList() : \_PhpScoper006a73f0e455\DoctrineIntersectionTypeIsSupertypeOf\Collection
    {
        return $this->bankAccountList;
    }
}
