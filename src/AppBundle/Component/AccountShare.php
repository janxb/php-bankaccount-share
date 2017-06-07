<?php
/**
 * Created by PhpStorm.
 * User: jan
 * Date: 06.06.17
 * Time: 16:39
 */

namespace AppBundle\Component;


use AppBundle\Entity\BankAccount;
use AppBundle\Entity\Roommate;
use AppBundle\Entity\RoommateCollection;
use AppBundle\Entity\RoommateTransactionHolder;
use DateTime;

class AccountShare
{
    private $roommates;
    private $bankAccount;

    /** @var  RoommateTransactionHolder */
    private $roommateTransactionHolder;
    private $dateStart;
    private $dateEnd;

    function __construct(BankAccount $bankAccount)
    {
        $this->roommates = new RoommateCollection();
        $this->bankAccount = $bankAccount;
    }

    public function addRoommate(Roommate $roommate)
    {
        $this->roommates->add($roommate);
    }

    public function process(DateTime $dateStart, DateTime $dateEnd)
    {
        $transactions = $this->bankAccount->getTransactions($dateStart, $dateEnd);
        $this->roommateTransactionHolder = new RoommateTransactionHolder($this->roommates, $transactions);
        $this->roommateTransactionHolder->process();
        return $this;
    }

    public function getRoommateAmounts()
    {
        $amounts = [];
        $this->roommates->each(function (Roommate $roommate) use (&$amounts) {
            $amounts[$roommate->getIdentifier()] = $this->roommateTransactionHolder->getAmountForRoommate($roommate);
        });
        return $amounts;
    }

    public function getRoommateTransactions()
    {
        $transactions = [];
        $this->roommates->each(function (Roommate $roommate) use (&$transactions) {
            $transactions[$roommate->getIdentifier()] = $this->roommateTransactionHolder->getTransactionsForRoommate($roommate);
        });
        return $transactions;
    }

    public function getUnidentifiedAmount(): float
    {
        return $this->roommateTransactionHolder->getUnidentifiedAmount();
    }
}