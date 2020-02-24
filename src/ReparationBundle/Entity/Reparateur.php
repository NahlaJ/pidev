<?php

namespace ReparationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reparateur
 *
 * @ORM\Table(name="reparateur")
 * @ORM\Entity(repositoryClass="ReparationBundle\Repository\ReparateurRepository")
 */
class Reparateur
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
     * @ORM\Column(name="Nom", type="string", length=255)
     */
    private $nom;
    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255 ,options={"unsigned":"libre", "default":"libre"})
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
     * @var string
     *
     * @ORM\Column(name="Prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var int
     *
     * @ORM\Column(name="NumTel", type="integer")
     */
    private $numTel;
    /**
     * @var int
     *
     * @ORM\Column(name="nbr_velo_repare", type="integer")
     */
    private $nbrVeloRepare;

    /**
     * @return int
     */
    public function getNbrVeloRepare()
    {
        return $this->nbrVeloRepare;
    }

    /**
     * @param int $nbrVeloRepare
     */
    public function setNbrVeloRepare($nbrVeloRepare)
    {
        $this->nbrVeloRepare = $nbrVeloRepare;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="Experience", type="integer")
     */
    private $experience;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return Reparateur
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Reparateur
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set numTel
     *
     * @param integer $numTel
     *
     * @return Reparateur
     */
    public function setNumTel($numTel)
    {
        $this->numTel = $numTel;

        return $this;
    }

    /**
     * Get numTel
     *
     * @return int
     */
    public function getNumTel()
    {
        return $this->numTel;
    }

    /**
     * Set experience
     *
     * @param integer $experience
     *
     * @return Reparateur
     */
    public function setExperience($experience)
    {
        $this->experience = $experience;

        return $this;
    }

    /**
     * Get experience
     *
     * @return int
     */
    public function getExperience()
    {
        return $this->experience;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Reparateur
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
