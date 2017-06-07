<?php
/**
 * Created by PhpStorm.
 * User: jan
 * Date: 06.06.17
 * Time: 19:33
 */

namespace AppBundle\Entity;


use AppBundle\Entity\Abstr\IEquals;
use DateTime;

class Transaction implements IEquals
{
    private $amount;
    private $recipient;
    private $description;
    private $date;

    public function __construct(float $amount, string $recipient, DateTime $date, string $description = null)
    {
        $this->amount = $amount;
        $this->recipient = $recipient;
        $this->description = $description;
        $this->date = $date;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getRecipient(): string
    {
        return $this->recipient;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }

    /**
     * @param IEquals $other
     * @return bool
     */
    public function equals(IEquals $other)
    {
        if ($other instanceof Transaction
            && $other->getAmount() === $this->getAmount()
            && $other->getDate() === $this->getDate()
            && $other->getRecipient() === $this->getRecipient()
            && $other->getDescription() === $this->getDescription()
        )
            return true;
        else return false;
    }
}