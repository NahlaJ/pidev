<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VeloALouer
 *
 * @ORM\Table(name="velo_a_louer")
 * @ORM\Entity(repositoryClass="LocationBundle\Repository\VeloALouerRepository")
 */
class VeloALouer
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
     * @ORM\Column(name="caracteristiques", type="string", length=255)
     */
    private $caracteristiques;

    /**
     * @var int
     *
     * @ORM\Column(name="age", type="integer")
     */
    private $age;

    /**
     * @var float
     *
     * @ORM\Column(name="compteur", type="float")
     */
    private $compteur;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float")
     */
    private $prix;

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
     * @return VeloALouer
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
     * @return VeloALouer
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
     * @return VeloALouer
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
     * @return VeloALouer
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
     * @return VeloALouer
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
     * @return VeloALouer
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

