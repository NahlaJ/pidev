<?php

namespace CatalogueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProduitRating
 *
 * @ORM\Table(name="produit_rating")
 * @ORM\Entity(repositoryClass="CatalogueBundle\Repository\ProduitRatingRepository")
 */
class ProduitRating
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
     * @ORM\Column(name="rating", type="integer")
     */
    private $rating;

    /**
     * @ORM\ManyToOne(targetEntity="CatalogueBundle\Entity\Produit")
     * @ORM\JoinColumn(name="idProduit",referencedColumnName="id")
     *
     */
    private $produit ;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="idUser",referencedColumnName="id")
     *
     */
    private $user ;

    /**
     * @return mixed
     */
    public function getProduit()
    {
        return $this->produit;
    }

    /**
     * @param mixed $produit
     */
    public function setProduit($produit)
    {
        $this->produit = $produit;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
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
     * Set rating
     *
     * @param integer $rating
     *
     * @return ProduitRating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return int
     */
    public function getRating()
    {
        return $this->rating;
    }
}


