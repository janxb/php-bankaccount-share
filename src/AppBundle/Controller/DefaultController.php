<?php

namespace AppBundle\Controller;

use Fhp\FinTs;
use Fhp\Model\SEPAAccount;
use Fhp\Model\StatementOfAccount\Statement;
use Fhp\Model\StatementOfAccount\Transaction;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $fints = new FinTs(
            $this->getParameter('bank_hbci_url'),
            443,
            $this->getParameter('bank_code'),
            $this->getParameter('bank_online_username'),
            $this->getParameter('bank_online_password')
        );
        $accounts = $fints->getSEPAAccounts();
        $oneAccount = null;
        foreach ($accounts as $account) {
            if ($account->getAccountNumber() == $this->getParameter('bank_accountnumber')) {
                $oneAccount = $account;
                break;
            }
        }
        $from = new \DateTime('2016-01-01');
        $to = new \DateTime();
        $soa = $fints->getStatementOfAccount($oneAccount, $from, $to);

        echo '<pre>';
        foreach ($soa->getStatements() as $statement) {
            foreach ($statement->getTransactions() as $transaction) {
                echo $transaction->getBookingDate()->format('d.m.Y') . ' - ' . $transaction->getAmount() . ' - ' . $transaction->getDescription1();
                echo "\n";
            }
        }
        echo '</pre>';

        return new Response();
    }
}
