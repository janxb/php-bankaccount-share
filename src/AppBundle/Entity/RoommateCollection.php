<?php
/**
 * Created by PhpStorm.
 * User: jan
 * Date: 06.06.17
 * Time: 18:38
 */

namespace AppBundle\Entity;


class RoommateCollection
{
    /** @var  Roommate[] */
    private $roommates = [];

    public function add(Roommate $roommate)
    {
        if (!in_array($roommate, $this->roommates))
            array_push($this->roommates, $roommate);
        return $this;
    }

    public function remove(Roommate $roommate)
    {
        if (($key = array_search($roommate, $this->roommates, true)) !== FALSE)
            unset($this->roommates[$key]);
        return $this;
    }

    public function contains(Roommate $roommate)
    {
        return in_array($roommate, $this->roommates);
    }

    public function each(callable $callback)
    {
        if (!is_callable($callback))
            return;

        foreach ($this->roommates as $roommate) {
            call_user_func_array($callback, [$roommate]);
        }
    }

    public function getSize()
    {
        return sizeof($this->roommates);
    }

    public function clear()
    {
        $this->roommates = [];
        return $this;
    }
}