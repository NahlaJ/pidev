<?php

namespace EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservationevent
 *
 * @ORM\Table(name="reservationevent")
 * @ORM\Entity(repositoryClass="EventBundle\Repository\ReservationeventRepository")
 */
class Reservationevent
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="idEvent", type="integer")
     */
    private $idEvent;

    /**
     * @var int
     *
     * @ORM\Column(name="idClient", type="integer")
     */
    private $idClient;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idEvent
     *
     * @param integer $idEvent
     *
     * @return Reservationevent
     */
    public function setIdEvent($idEvent)
    {
        $this->idEvent = $idEvent;

        return $this;
    }

    /**
     * Get idEvent
     *
     * @return int
     */
    public function getIdEvent()
    {
        return $this->idEvent;
    }

    /**
     * Set idClient
     *
     * @param integer $idClient
     *
     * @return Reservationevent
     */
    public function setIdClient($idClient)
    {
        $this->idClient = $idClient;

        return $this;
    }

    /**
     * Get idClient
     *
     * @return int
     */
    public function getIdClient()
    {
        return $this->idClient;
    }
}

