<?php

namespace ReparationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VeloAReparer
 *
 * @ORM\Table(name="velo_a_reparer")
 * @ORM\Entity(repositoryClass="ReparationBundle\Repository\VeloAReparerRepository")
 */
class VeloAReparer
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
     * @var string
     *
     * @ORM\Column(name="marque", type="string", length=255)
     */
    private $marque;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="probleme", type="string", length=255)
     */
    private $probleme;

    /**
     * @var int
     *
     * @ORM\Column(name="age", type="integer")
     */
    private $age;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateR", type="datetime")
     */
    private $dateR;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;


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
     * Set marque
     *
     * @param string $marque
     *
     * @return \MainBundle\Entity\VeloAReparer
     */
    public function setMarque($marque)
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * Get marque
     *
     * @return string
     */
    public function getMarque()
    {
        return $this->marque;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return VeloAReparer
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
     * Set probleme
     *
     * @param string $probleme
     *
     * @return VeloAReparer
     */
    public function setProbleme($probleme)
    {
        $this->probleme = $probleme;

        return $this;
    }

    /**
     * Get probleme
     *
     * @return string
     */
    public function getProbleme()
    {
        return $this->probleme;
    }

    /**
     * Set age
     *
     * @param integer $age
     *
     * @return VeloAReparer
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set dateR
     *
     * @param \DateTime $dateR
     *
     * @return VeloAReparer
     */
    public function setDateR($dateR)
    {
        $this->dateR = $dateR;

        return $this;
    }

    /**
     * Get dateR
     *
     * @return \DateTime
     */
    public function getDateR()
    {
        return $this->dateR;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return VeloAReparer
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }


}

