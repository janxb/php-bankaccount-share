<?php
/**
 * Created by PhpStorm.
 * User: jan
 * Date: 06.06.17
 * Time: 18:38
 */

namespace AppBundle\Entity\Abstr;


abstract class AbstractCollection
{
    private $values = [];

    /**
     * @param $value
     * @return void
     * @throws \InvalidArgumentException
     */
    abstract protected function validateType($value);

    public function add($value)
    {
        $this->validateType($value);
        if (!in_array($value, $this->values))
            array_push($this->values, $value);
        return $this;
    }

    public function remove($value)
    {
        $this->validateType($value);
        if (($key = array_search($value, $this->values, true)) !== FALSE)
            unset($this->values[$key]);
        return $this;
    }

    public function contains($value)
    {
        $this->validateType($value);
        $isFound = false;
        $this->each(function (IEquals $element) use ($value, &$isFound) {
            if ($element->equals($value))
                $isFound = true;
        });
        return $isFound;
    }

    public function each(callable $callback)
    {
        if (!is_callable($callback))
            return;

        foreach ($this->values as $value) {
            call_user_func_array($callback, [$value]);
        }
    }

    public function getSize()
    {
        return sizeof($this->values);
    }

    public function clear()
    {
        $this->values = [];
        return $this;
    }
}