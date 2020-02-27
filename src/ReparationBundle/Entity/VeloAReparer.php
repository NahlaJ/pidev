<?php

namespace ReparationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * VeloAReparer
 *
 * @ORM\Table(name="velo_a_reparer")
 * @ORM\Entity(repositoryClass="ReparationBundle\Repository\VeloAReparerRepository")
 */
class VeloAReparer
{
    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * ORM\JoinColumn(name="user_id",referencedColumnName="id")
     */
    private $User;

    /**
     * @ORM\ManyToOne(targetEntity="ReparationBundle\Entity\Reparateur")
     * ORM\JoinColumn(name="reparateur_id",referencedColumnName="id")
     */
    private $Reparateur;

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
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */

    private $status;

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateR", type="datetime")
     */
    private $dateR;

    /**
     * @var string
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
     * @return \ReparationBundle\Entity\VeloAReparer
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



    /**
     * Set reparateur
     *
     * @param \ReparationBundle\Entity\Reparateur $reparateur
     *
     * @return VeloAReparer
     */
    public function setReparateur(\ReparationBundle\Entity\Reparateur $reparateur )
    {
        $this->Reparateur = $reparateur;

        return $this;
    }

    public  function setRepNull(){
        $this->Reparateur = null;
        return $this;
    }

    /**
     * Get reparateur
     *
     * @return \ReparationBundle\Entity\Reparateur
     */
    public function getReparateur()
    {
        return $this->Reparateur;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return VeloAReparer
     */
    public function setUser(\UserBundle\Entity\User $user = null)
    {
        $this->User = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->User;
    }

    /**
     * @ORM\OneToOne(targetEntity="Facture", mappedBy="veloAReparer")
     */
    private $facture = null;

    /**
     * @return null
     */
    public function getFacture()
    {
        return $this->facture;
    }

    /**
     * @param null $facture
     */
    public function setFacture($facture)
    {
        $this->facture = $facture;
    }


}
