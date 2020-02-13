<?php

namespace EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="EventBundle\Repository\EventRepository")
 */
class Event
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idEvent", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idevent;

    /**
     * @var string
     *
     * @ORM\Column(name="dateevent", type="string", length=255)
     */
    private $dateevent;

    /**
     * @var string
     *
     * @ORM\Column(name="lieuevent", type="string", length=255)
     */
    private $lieuevent;

    /**
     * @var int
     *
     * @ORM\Column(name="nbrepersonnes", type="integer")
     */
    private $nbrepersonnes;

    /**
     * @var int
     *
     * @ORM\Column(name="capevent", type="integer")
     */
    private $capevent;

    /**
     * @var string
     *
     * @ORM\Column(name="nomevent", type="string", length=255)
     */
    private $nomevent;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="ticketprice", type="float")
     */
    private $ticketprice;

    /**
     * @var string
     *
     * @ORM\Column(name="eventImg", type="string", length=255)
     */
    private $eventImg;

    /**
     * @return int
     */
    public function getIdevent()
    {
        return $this->idevent;
    }

    /**
     * @param int $idevent
     */
    public function setIdevent($idevent)
    {
        $this->idevent = $idevent;
    }


    /**
     * Set dateevent
     *
     * @param string $dateevent
     *
     * @return Event
     */
    public function setDateevent($dateevent)
    {
        $this->dateevent = $dateevent;

        return $this;
    }

    /**
     * Get dateevent
     *
     * @return string
     */
    public function getDateevent()
    {
        return $this->dateevent;
    }

    /**
     * Set lieuevent
     *
     * @param string $lieuevent
     *
     * @return Event
     */
    public function setLieuevent($lieuevent)
    {
        $this->lieuevent = $lieuevent;

        return $this;
    }

    /**
     * Get lieuevent
     *
     * @return string
     */
    public function getLieuevent()
    {
        return $this->lieuevent;
    }

    /**
     * Set nbrepersonnes
     *
     * @param integer $nbrepersonnes
     *
     * @return Event
     */
    public function setNbrepersonnes($nbrepersonnes)
    {
        $this->nbrepersonnes = $nbrepersonnes;

        return $this;
    }

    /**
     * Get nbrepersonnes
     *
     * @return int
     */
    public function getNbrepersonnes()
    {
        return $this->nbrepersonnes;
    }

    /**
     * Set capevent
     *
     * @param integer $capevent
     *
     * @return Event
     */
    public function setCapevent($capevent)
    {
        $this->capevent = $capevent;

        return $this;
    }

    /**
     * Get capevent
     *
     * @return int
     */
    public function getCapevent()
    {
        return $this->capevent;
    }

    /**
     * Set nomevent
     *
     * @param string $nomevent
     *
     * @return Event
     */
    public function setNomevent($nomevent)
    {
        $this->nomevent = $nomevent;

        return $this;
    }

    /**
     * Get nomevent
     *
     * @return string
     */
    public function getNomevent()
    {
        return $this->nomevent;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Event
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set ticketprice
     *
     * @param float $ticketprice
     *
     * @return Event
     */
    public function setTicketprice($ticketprice)
    {
        $this->ticketprice = $ticketprice;

        return $this;
    }

    /**
     * Get ticketprice
     *
     * @return float
     */
    public function getTicketprice()
    {
        return $this->ticketprice;
    }

    /**
     * Set eventImg
     *
     * @param string $eventImg
     *
     * @return Event
     */
    public function setEventImg($eventImg)
    {
        $this->eventImg = $eventImg;

        return $this;
    }

    /**
     * Get eventImg
     *
     * @return string
     */
    public function getEventImg()
    {
        return $this->eventImg;
    }
}

