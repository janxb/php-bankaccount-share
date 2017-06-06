<?php
/**
 * Created by PhpStorm.
 * User: jan
 * Date: 06.06.17
 * Time: 17:03
 */

namespace Tests\AppBundle\Controller;


use AppBundle\Entity\Roommate;
use PHPUnit\Framework\TestCase;

class RoommateTest extends TestCase
{
    public function testIsNameMatched()
    {
    $roommate = new Roommate();
    $roommate->addName("First Name");
    $roommate->addName("Second Name");

    self::assertTrue($roommate->isNameMatching("Second Name"));
    self::assertTrue($roommate->isNameMatching("First Name"));
    self::assertFalse($roommate->isNameMatching("Third Name"));
    }
}