<?php
/**
 * Created by PhpStorm.
 * User: jan
 * Date: 06.06.17
 * Time: 20:16
 */

namespace AppBundle\Entity;


use AppBundle\Entity\Abstr\AbstractCollection;

class TransactionCollection extends AbstractCollection
{
    protected function validateType($value)
    {
        if (!$value instanceof Transaction)
            throw new \InvalidArgumentException();
    }
}