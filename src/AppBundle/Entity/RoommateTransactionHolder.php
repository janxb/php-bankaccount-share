<?php
/**
 * Created by PhpStorm.
 * User: jan
 * Date: 06.06.17
 * Time: 20:13
 */

namespace AppBundle\Entity;


class RoommateTransactionHolder
{
    private $roommates;
    private $transactions;

    private $roommateAmountMap = [];
    private $roommateTransactionMap = [];

    /**
     * RoommateTransactionHolder constructor.
     * @param $roommates RoommateCollection
     * @param $transactions TransactionCollection
     */
    public function __construct(RoommateCollection $roommates, TransactionCollection $transactions)
    {
        $this->roommates = $roommates;
        $this->transactions = $transactions;
    }

    public function process()
    {
        $this->roommates->each(function (Roommate $roommate) {
            $this->roommateAmountMap[$roommate->getIdentifier()] = 0;
        });

        $this->transactions->each(function (Transaction $transaction) {
            $this->roommates->each(function (Roommate $roommate) use ($transaction) {
                if ($roommate->isNameMatching($transaction->getRecipient())) {
                    $this->roommateAmountMap[$roommate->getIdentifier()] += $transaction->getAmount();
                    $this->roommateTransactionMap[$roommate->getIdentifier()][] = $transaction;
                }
            });
        });
    }

    public function getAmountForRoommate(Roommate $roommate)
    {
        return $this->roommateAmountMap[$roommate->getIdentifier()];
    }

    public function getMappedTransactionsForRoommate(Roommate $roommate)
    {
        return $this->roommateTransactionMap[$roommate->getIdentifier()];
    }

    public function getAllMappedTransactions()
    {
        return $this->roommateTransactionMap;
    }
}