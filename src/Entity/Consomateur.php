<?php

namespace App\Entity;

use App\Repository\ConsomateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConsomateurRepository::class)
 */
class Consomateur extends Personne
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Emplacement::class, mappedBy="consomateur")
     */
    private $emplacement;

    /**
     * @ORM\OneToMany(targetEntity=Commande::class, mappedBy="passer")
     */
    private $commandes;

    public function __construct($nom, $prenom, $email, $tel)
    {
        parent::__construct($nom, $prenom, $email, $tel);
        $this->emplacement = new ArrayCollection();
        $this->commandes = new ArrayCollection();

    }


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Emplacement[]
     */
    public function getEmplacement(): Collection
    {
        return $this->emplacement;
    }

    public function addEmplacement(Emplacement $emplacement): self
    {
        if (!$this->emplacement->contains($emplacement)) {
            $this->emplacement[] = $emplacement;
            $emplacement->setConsomateur($this);
        }

        return $this;
    }

    public function removeEmplacement(Emplacement $emplacement): self
    {
        if ($this->emplacement->removeElement($emplacement)) {
            // set the owning side to null (unless already changed)
            if ($emplacement->getConsomateur() === $this) {
                $emplacement->setConsomateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Commande[]
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setPasser($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getPasser() === $this) {
                $commande->setPasser(null);
            }
        }

        return $this;
    }
}
