<?php
/**
 * Created by PhpStorm.
 * User: jan
 * Date: 06.06.17
 * Time: 18:43
 */

namespace Tests\AppBundle;


use AppBundle\Entity\Roommate;
use AppBundle\Entity\RoommateCollection;
use PHPUnit\Framework\TestCase;

class RoommateCollectionTest extends TestCase
{
    private function prepareCollection()
    {
        $roommateOne = (new Roommate("firstMate"))->addName('First Mate');
        $roommateTwo = (new Roommate("secondMate"))->addName('Second Mate');
        $roommateCollection = (new RoommateCollection())
            ->add($roommateOne)
            ->add($roommateTwo);
        return $roommateCollection;
    }

    public function testEach()
    {
        $roommateCollection = $this->prepareCollection();

        $counter = 0;

        $roommateCollection->each(function (Roommate $roommate) use (&$counter) {
            $counter++;
        });

        self::assertEquals($roommateCollection->getSize(), $counter);
    }

    public function testContains()
    {
        $roommateCollection = $this->prepareCollection();
        self::assertTrue($roommateCollection->contains(new Roommate("firstMate")));
        self::assertFalse($roommateCollection->contains(new Roommate("thirdMate")));
    }

    public function testClear()
    {
        $roommateCollection = $this->prepareCollection();
        self::assertEquals(2, $roommateCollection->getSize());
        $roommateCollection->clear();
        self::assertEquals(0, $roommateCollection->getSize());
    }
}