<?php

namespace _PhpScoperbd5d0c5f7638\Bug2676ReturnTypeRule;

use _PhpScoperbd5d0c5f7638\DoctrineIntersectionTypeIsSupertypeOf\Collection;
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
    public function getBankAccountList() : \_PhpScoperbd5d0c5f7638\DoctrineIntersectionTypeIsSupertypeOf\Collection
    {
        return $this->bankAccountList;
    }
}
