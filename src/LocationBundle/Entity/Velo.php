<?php

namespace LocationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Velo
 *
 * @ORM\Table(name="velo")
 * @ORM\Entity(repositoryClass="LocationBundle\Repository\VeloRepository")
 */
class Velo
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
     * @Assert\NotBlank
     * @Assert\Length(
     *     min=5,
     *     minMessage= "marque length must be at least {{limit}} characters long "
     * )
     */
    private $marque;

    /**
     * @var string
     *
     * @ORM\Column(name="caracteristiques", type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(
     *     min=5,
     *     minMessage= "marque length must be at least {{limit}} characters long "
     * )
     *
     */
    private $caracteristiques;

    /**
     * @var int
     *
     * @ORM\Column(name="age", type="integer")
     * @Assert\Range(
     *     min=1,
     *     max=500
     * )
     */
    private $age;

    /**
     * @var float
     *
     * @ORM\Column(name="compteur", type="float")
     * @Assert\Range(
     *     min=1,
     *     max=500
     * )
     */
    private $compteur;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float")
     * @Assert\Range(
     *     min=1,
     *     max=500
     * )
     *
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     *  @Assert\NotBlank
     * @Assert\Length(
     *     min=5,
     *     minMessage= "marque length must be at least {{limit}} characters long "
     * )
     */
    private $image;

    /**
     * @var int
     *
     * @ORM\Column(name="etat", type="integer")
     *  @Assert\Range(
     *     min=1,
     * )
     */
    private $etat=1;

    /**
     * Velo constructor.
     */
    public function __construct()
    {
    }


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
     * @return Velo
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
     * Set caracteristiques
     *
     * @param string $caracteristiques
     *
     * @return Velo
     */
    public function setCaracteristiques($caracteristiques)
    {
        $this->caracteristiques = $caracteristiques;

        return $this;
    }

    /**
     * Get caracteristiques
     *
     * @return string
     */
    public function getCaracteristiques()
    {
        return $this->caracteristiques;
    }

    /**
     * Set age
     *
     * @param integer $age
     *
     * @return Velo
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
     * Set compteur
     *
     * @param float $compteur
     *
     * @return Velo
     */
    public function setCompteur($compteur)
    {
        $this->compteur = $compteur;

        return $this;
    }

    /**
     * Get compteur
     *
     * @return float
     */
    public function getCompteur()
    {
        return $this->compteur;
    }

    /**
     * Set prix
     *
     * @param float $prix
     *
     * @return Velo
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Velo
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
     * Set etat
     *
     * @param integer $etat
     *
     * @return Velo
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return int
     */
    public function getEtat()
    {
        return $this->etat;
    }
}

