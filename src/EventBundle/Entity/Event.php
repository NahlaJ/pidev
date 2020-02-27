<?php

namespace EventBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use EventBundle\Entity\Reservationevent;
use Symfony\Component\Validator\Constraints\Date;

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
     * @var \DateTime
     *
     * @Assert\GreaterThan("today")
     * @ORM\Column(name="dateEvent", type="datetime")
     */
    private $dateevent;




    /**
     * @var string
     *
     * @ORM\Column(name="lieuEvent", type="string", length=255, nullable=false)
     * @Assert\NotBlank
     * @Assert\Length(
     *     min = 3,
     *     max = 25,
     *     minMessage = "lieu event must be at least {{limit}}  characters long",
     *     maxMessage = " lieu event cannot be longer than {{limit}} characters ",
     *     )
     */
    private $lieuevent;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbrePersonnes", type="integer", nullable=false)
     */
    private $nbrepersonnes;

    /**
     * @var integer
     *
     * @ORM\Column(name="capEvent", type="integer", nullable=false)
     */
    private $capevent;

    /**
     * @var string
     *
     * @ORM\Column(name="nomEvent", type="string", length=255, nullable=false)
     */
    private $nomevent;

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Length(
     *     min = 5,
     *     max = 25,
     *     minMessage = "Nom event must be at least {{limit}}  characters long",
     *     maxMessage = " Nom event cannot be longer than {{limit}} characters ",
     *     )
     * @ORM\Column(name="description", type="string", length=100, nullable=false)
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="ticketPrice", type="float", precision=10, scale=0, nullable=false)
     */
    private $ticketprice;
    /**
     * @var string
     * @Assert\File(mimeTypes={ "image/jpeg", "image/png"})
     * @ORM\Column(name="eventImg", type="string", length=255, nullable=false)
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
/*
    /**
     * @var string
     * @Assert\File(mimeTypes={ "image/jpeg", "image/png"})
     * @ORM\Column(name="image", type="string")

    private $image;

    /**
     * @return string

    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image

    public function setImage($image)
    {
        $this->image = $image;
    }
*/




    /**
     * @return string
     */
    public function getLieuevent()
    {
        return $this->lieuevent;
    }

    /**
     * @param string $lieuevent
     */
    public function setLieuevent($lieuevent)
    {
        $this->lieuevent = $lieuevent;
    }

    /**
     * @return int
     */
    public function getNbrepersonnes()
    {
        return $this->nbrepersonnes;
    }

    /**
     * @param int $nbrepersonnes
     */
    public function setNbrepersonnes($nbrepersonnes)
    {
        $this->nbrepersonnes = $nbrepersonnes;
    }

    /**
     * @return int
     */
    public function getCapevent()
    {
        return $this->capevent;
    }

    /**
     * @param int $capevent
     */
    public function setCapevent($capevent)
    {
        $this->capevent = $capevent;
    }

    /**
     * @return string
     */
    public function getNomevent()
    {
        return $this->nomevent;
    }

    /**
     * @param string $nomevent
     */
    public function setNomevent($nomevent)
    {
        $this->nomevent = $nomevent;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return float
     */
    public function getTicketprice()
    {
        return $this->ticketprice;
    }

    /**
     * @param float $ticketprice
     */
    public function setTicketprice($ticketprice)
    {
        $this->ticketprice = $ticketprice;
    }
    /**
     * @return string
     */
    public function getEventImg()
    {
        return $this->eventImg;
    }
    /**
     * @param string $eventImg
     */
    public function setEventImg($eventImg)
    {
        $this->eventImg = $eventImg;
    }



    /**
     * Set dateevent
     *
     * @param \DateTime $dateevent
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
     * @return \DateTime
     */
    public function getDateevent()
    {
        return $this->dateevent;
    }
}
