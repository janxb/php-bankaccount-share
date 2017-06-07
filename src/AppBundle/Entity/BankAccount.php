<?php
/**
 * Created by PhpStorm.
 * User: jan
 * Date: 06.06.17
 * Time: 19:08
 */

namespace AppBundle\Entity;


use AppBundle\Component\FintsAbsoluteAmountConverter;
use DateTime;
use Fhp\FinTs;

class BankAccount
{
    private $account;
    private $finTs;

    public function __construct($accountNumber, $bankCode, $hbciUrl, $hbciUsername, $hbciPassword)
    {
        $this->finTs = new FinTs(
            $hbciUrl,
            443,
            $bankCode,
            $hbciUsername,
            $hbciPassword
        );

        foreach ($this->finTs->getSEPAAccounts() as $SEPAAccount) {
            if ($SEPAAccount->getAccountNumber() == $accountNumber) {
                $this->account = $SEPAAccount;
                break;
            }
        }
    }

    /**
     * @param DateTime $dateStart
     * @param DateTime $dateEnd
     * @return TransactionCollection
     */
    public function getTransactions(DateTime $dateStart, DateTime $dateEnd)
    {
        $transactions = new TransactionCollection();
        $statementOfAccount = $this->finTs->getStatementOfAccount(
            $this->account, $dateStart, $this->trimDateNotAfterNow($dateEnd));
        foreach ($statementOfAccount->getStatements() as $statement) {
            foreach ($statement->getTransactions() as $hbciTransaction) {
                if ($this->isDateAfterDeadline($hbciTransaction->getBookingDate(), $dateEnd))
                    continue;
                $transaction = new Transaction(
                    FintsAbsoluteAmountConverter::getAbsoluteAmount($hbciTransaction),
                    $hbciTransaction->getName(),
                    $hbciTransaction->getBookingDate(),
                    $hbciTransaction->getDescription1() . $hbciTransaction->getDescription2()
                );
                $transactions->add($transaction);
            }
        }
        return $transactions;
    }

    private function isDateAfterDeadline(DateTime $date, DateTime $deadline)
    {
        return $deadline < $date;
    }

    private function trimDateNotAfterNow(DateTime $date)
    {
        if ($date > new DateTime())
            return new DateTime();
        else return $date;
    }
}