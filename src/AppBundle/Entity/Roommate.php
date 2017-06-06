<?php
/**
 * Created by PhpStorm.
 * User: jan
 * Date: 06.06.17
 * Time: 16:41
 */

namespace AppBundle\Entity;


class Roommate
{
    /** @var  string[] */
    private $names = [];

    public function addName(string $name)
    {
        if (!in_array($name, $this->names)) {
            array_push($this->names, $name);
        }
    }

    public function getFirstName()
    {
        return $this->names[0];
    }

    public function isNameMatching(string $givenName)
    {
        foreach ($this->names as $name) {
            if ($givenName === $name)
                return true;
        }
        return false;
    }
}