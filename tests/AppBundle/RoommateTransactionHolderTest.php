<?php
/**
 * Created by PhpStorm.
 * User: jan
 * Date: 07.06.17
 * Time: 08:35
 */

namespace Tests\AppBundle;


use AppBundle\Entity\Roommate;
use AppBundle\Entity\RoommateCollection;
use AppBundle\Entity\RoommateTransactionHolder;
use AppBundle\Entity\Transaction;
use AppBundle\Entity\TransactionCollection;
use PHPUnit\Framework\TestCase;

class RoommateTransactionHolderTest extends TestCase
{
    public function testProcess()
    {
        $roommateCollection = (new RoommateCollection())
            ->add((new Roommate("firstMate"))->addName("First Mate"))
            ->add((new Roommate("secondMate"))->addName("Second Mate"));

        $transactionCollection = (new TransactionCollection())
            ->add(new Transaction(100, "First Mate", new \DateTime()))
            ->add(new Transaction(-400, "First Mate", new \DateTime()))
            ->add(new Transaction(-100, "Second Mate", new \DateTime()))
            ->add(new Transaction(-300, "Second Mate", new \DateTime()))
            ->add(new Transaction(500, "Second Mate", new \DateTime()))
            ->add(new Transaction(300, "Third Mate", new \DateTime()));

        $roommateTransactionHolder = new RoommateTransactionHolder($roommateCollection, $transactionCollection);
        $roommateTransactionHolder->process();

        $amountRoommateOne = $roommateTransactionHolder->getAmountForRoommate(new Roommate("firstMate"));
        $amountRoommateTwo = $roommateTransactionHolder->getAmountForRoommate(new Roommate("secondMate"));

        self::assertEquals(-300, $amountRoommateOne);
        self::assertEquals(100, $amountRoommateTwo);
    }
}