<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Person
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\PersonRepository")
 */
class Person
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="session", type="string", length=255)
     */
    private $session;

    /**
     * @var boolean
     *
     * @ORM\Column(name="served", type="boolean", nullable=true)
     */
    private $served;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set session
     *
     * @param string $session
     * @return string
     */
    public function setSession($session)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Get session
     *
     * @return string
     */
    public function getSession()
    {
        return $this->session;
    }


    /**
     * Set served
     *
     * @param boolean $served
     * @return Person
     */
    public function setServed($served)
    {
        $this->served = $served;

        return $this;
    }

    /**
     * Get served
     *
     * @return boolean 
     */
    public function getServed()
    {
        return $this->served;
    }
}
