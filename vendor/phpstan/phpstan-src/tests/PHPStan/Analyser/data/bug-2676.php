<?php

namespace _PhpScoperbd5d0c5f7638\Bug2676;

use _PhpScoperbd5d0c5f7638\DoctrineIntersectionTypeIsSupertypeOf\Collection;
use function PHPStan\Analyser\assertType;
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
function (\_PhpScoperbd5d0c5f7638\Bug2676\Wallet $wallet) : void {
    $bankAccounts = $wallet->getBankAccountList();
    \PHPStan\Analyser\assertType('DoctrineIntersectionTypeIsSupertypeOf\\Collection&iterable<Bug2676\\BankAccount>', $bankAccounts);
    foreach ($bankAccounts as $bankAccount) {
        \PHPStan\Analyser\assertType('_PhpScoperbd5d0c5f7638\\Bug2676\\BankAccount', $bankAccount);
    }
};
