<?php
/**
 * Created by PhpStorm.
 * User: jan
 * Date: 06.06.17
 * Time: 19:59
 */

namespace AppBundle\Component;


use Fhp\Model\StatementOfAccount\Transaction;

class FintsAbsoluteAmountConverter
{
    public static function getAbsoluteAmount(Transaction $transaction)
    {
        $creditDebitFactor = $transaction->getCreditDebit() === 'credit' ? 1 : -1;
        return $transaction->getAmount() * $creditDebitFactor;
    }
}