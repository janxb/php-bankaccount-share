<?php
/**
 * Created by PhpStorm.
 * User: jan
 * Date: 06.06.17
 * Time: 16:41
 */

namespace AppBundle\Entity;


use AppBundle\Entity\Abstr\IEquals;

class Roommate implements IEquals
{
    /** @var  string[] */
    private $names = [];
    private $identifier;

    public function __construct(string $identifier)
    {
        $this->identifier = $identifier;
    }

    public function addName(string $name)
    {
        if (!in_array($name, $this->names)) {
            array_push($this->names, $name);
        }
        return $this;
    }

    public function isNameMatching(string $givenName)
    {
        foreach ($this->names as $name) {
            if ($givenName === $name)
                return true;
        }
        return false;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param IEquals $other
     * @return bool
     */
    public function equals(IEquals $other)
    {
        if ($other instanceof Roommate &&
            $other->getIdentifier() === $this->identifier
        )
            return true;
        else return false;
    }
}