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
    private $unidentifiedAmount = 0.0;

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
            $tmpUnidentifiedAmount = $transaction->getAmount();
            $this->roommates->each(function (Roommate $roommate) use ($transaction, &$tmpUnidentifiedAmount) {
                if ($roommate->isNameMatching($transaction->getRecipient())) {
                    $this->roommateAmountMap[$roommate->getIdentifier()] += $transaction->getAmount();
                    $this->roommateTransactionMap[$roommate->getIdentifier()][] = $transaction;
                    $tmpUnidentifiedAmount = 0.0;
                }
            });
            $this->unidentifiedAmount += $tmpUnidentifiedAmount;
        });
    }

    public function getAmountForRoommate(Roommate $roommate)
    {
        return $this->roommateAmountMap[$roommate->getIdentifier()];
    }

    public function getTransactionsForRoommate(Roommate $roommate)
    {
        return $this->roommateTransactionMap[$roommate->getIdentifier()];
    }

    public function getAllTransactions()
    {
        return $this->roommateTransactionMap;
    }

    /**
     * @return float
     */
    public function getUnidentifiedAmount(): float
    {
        return $this->unidentifiedAmount;
    }
}