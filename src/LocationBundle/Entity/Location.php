<?php

namespace LocationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Location
 *
 * @ORM\Table(name="location")
 * @ORM\Entity(repositoryClass="LocationBundle\Repository\LocationRepository")
 */
class Location
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
     * @var \DateTime
     *
     * @ORM\Column(name="dateDebut", type="datetime")
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFin", type="datetime")
     */
    private $dateFin;

    /**
     * @var float
     *
     * @ORM\Column(name="heureDebut", type="float")
     */
    private $heureDebut;

    /**
     * @var float
     *
     * @ORM\Column(name="heureFin", type="float")
     */
    private $heureFin;

    /**
     * @var float
     *
     * @ORM\Column(name="nbheures", type="float")
     */
    private $nbheures;

    /**
     * @var int
     *
     * @ORM\Column(name="nbJours", type="integer")
     */
    private $nbJours;


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
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     *
     * @return \MainBundle\Entity\Location
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     *
     * @return Location
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * Set heureDebut
     *
     * @param float $heureDebut
     *
     * @return Location
     */
    public function setHeureDebut($heureDebut)
    {
        $this->heureDebut = $heureDebut;

        return $this;
    }

    /**
     * Get heureDebut
     *
     * @return float
     */
    public function getHeureDebut()
    {
        return $this->heureDebut;
    }

    /**
     * Set heureFin
     *
     * @param float $heureFin
     *
     * @return Location
     */
    public function setHeureFin($heureFin)
    {
        $this->heureFin = $heureFin;

        return $this;
    }

    /**
     * Get heureFin
     *
     * @return float
     */
    public function getHeureFin()
    {
        return $this->heureFin;
    }

    /**
     * Set nbheures
     *
     * @param float $nbheures
     *
     * @return Location
     */
    public function setNbheures($nbheures)
    {
        $this->nbheures = $nbheures;

        return $this;
    }

    /**
     * Get nbheures
     *
     * @return float
     */
    public function getNbheures()
    {
        return $this->nbheures;
    }

    /**
     * Set nbJours
     *
     * @param integer $nbJours
     *
     * @return Location
     */
    public function setNbJours($nbJours)
    {
        $this->nbJours = $nbJours;

        return $this;
    }

    /**
     * Get nbJours
     *
     * @return int
     */
    public function getNbJours()
    {
        return $this->nbJours;
    }


}

