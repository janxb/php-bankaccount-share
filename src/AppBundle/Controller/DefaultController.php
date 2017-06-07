<?php

namespace AppBundle\Controller;

use AppBundle\Component\AccountShare;
use AppBundle\Entity\BankAccount;
use AppBundle\Entity\MonthYear;
use AppBundle\Entity\Roommate;
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
        $bankAccount = new BankAccount(
            $this->getParameter('bank_accountnumber'),
            $this->getParameter('bank_code'),
            $this->getParameter('bank_hbci_url'),
            $this->getParameter('bank_online_username'),
            $this->getParameter('bank_online_password')
        );

        $accountShare = new AccountShare($bankAccount);
        $accountShare->addRoommate(new Roommate("Jan Brodda"));
        $accountShare->addRoommate(new Roommate("Nick Brodda"));

        $month6 = new MonthYear(6, 2017);
        $month5 = new MonthYear(5, 2017);
        $month4 = new MonthYear(4, 2017);
        $month3 = new MonthYear(3, 2017);

        dump($accountShare->process($month6->getFirstDateTime(), $month6->getLastDateTime())->getRoommateAmounts());
        dump($accountShare->process($month5->getFirstDateTime(), $month5->getLastDateTime())->getRoommateAmounts());


        return new Response();
    }
}
