<?php
/**
 * Created by PhpStorm.
 * User: jan
 * Date: 07.06.17
 * Time: 08:55
 */

namespace AppBundle\Entity\Abstr;


interface IEquals
{
    /**
     * @param IEquals $other
     * @return bool
     */
    public function equals(IEquals $other);
}