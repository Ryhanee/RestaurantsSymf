<?php

namespace App\Entity;

use App\Repository\EmplacementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmplacementRepository::class)
 */
class Emplacement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id_emp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;



    /**
     * @ORM\OneToOne(targetEntity=Livraison::class, mappedBy="emplacement", cascade={"persist", "remove"})
     */
    private $livraison;

    /**
     * @ORM\OneToOne(targetEntity=Restaurant::class, mappedBy="adresse_resto", cascade={"persist", "remove"})
     */
    private $restaurant;

    /**
     * @ORM\ManyToOne(targetEntity=Consomateur::class, inversedBy="emplacement")
     */
    private $consomateur;

    public function getId(): ?int
    {
        return $this->id_emp;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getEmplacement(): ?Restaurant
    {
        return $this->restaurant;
    }

    public function setEmplacement(?Restaurant $restaurant): self
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    public function getLivraison(): ?Livraison
    {
        return $this->livraison;
    }

    public function setLivraison(Livraison $livraison): self
    {
        $this->livraison = $livraison;

        // set the owning side of the relation if necessary
        if ($livraison->getEmplacement() !== $this) {
            $livraison->setEmplacement($this);
        }

        return $this;
    }

    public function getRestaurant(): ?Restaurant
    {
        return $this->restaurant;
    }

    public function setRestaurant(Restaurant $restaurant): self
    {
        $this->restaurant = $restaurant;

        // set the owning side of the relation if necessary
        if ($restaurant->getAdresseResto() !== $this) {
            $restaurant->setAdresseResto($this);
        }

        return $this;
    }

    public function getConsomateur(): ?Consomateur
    {
        return $this->consomateur;
    }

    public function setConsomateur(?Consomateur $consomateur): self
    {
        $this->consomateur = $consomateur;

        return $this;
    }
}
