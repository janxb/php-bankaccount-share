<?php
/**
 * Created by PhpStorm.
 * User: jan
 * Date: 07.06.17
 * Time: 16:54
 */

namespace AppBundle\Entity;


use DateTime;
use InvalidArgumentException;

class MonthYear
{
    private $month;
    private $year;

    public function __construct(int $month, int $year)
    {
        if ($month > 12 || $month < 1)
            throw new InvalidArgumentException("Given month is not valid.");

        $this->month = $month;
        $this->year = $year;
    }

    /**
     * @return int
     */
    public function getMonth(): int
    {
        return $this->month;
    }

    /**
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    public function getLastDateTime()
    {
        return new DateTime($this->getFirstDateTime()->format("Y-m-t"));
    }

    public function getFirstDateTime()
    {
        return new DateTime("$this->year-$this->month-01");
    }
}