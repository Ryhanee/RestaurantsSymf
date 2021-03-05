<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $delai_livraison;

    /**
     * @ORM\ManyToOne(targetEntity=Livreur::class, inversedBy="commandes")
     */
    private $livreur_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $statut;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $montant_cmd;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_cmd;

    /**
     * @ORM\Column(type="float")
     */
    private $prix_total_liv;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mode_de_paiment;

    /**
     * @ORM\ManyToOne(targetEntity=Consomateur::class, inversedBy="commandes")
     */
    private $passer;

    /**
     * @ORM\OneToMany(targetEntity=Plats::class, mappedBy="commande")
     */
    private $contient;

    public function __construct()
    {
        $this->contient = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDelaiLivraison(): ?int
    {
        return $this->delai_livraison;
    }

    public function setDelaiLivraison(?int $delai_livraison): self
    {
        $this->delai_livraison = $delai_livraison;

        return $this;
    }

    public function getLivreurId(): ?Livreur
    {
        return $this->livreur_id;
    }

    public function setLivreurId(?Livreur $livreur_id): self
    {
        $this->livreur_id = $livreur_id;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getMontantCmd(): ?float
    {
        return $this->montant_cmd;
    }

    public function setMontantCmd(?float $montant_cmd): self
    {
        $this->montant_cmd = $montant_cmd;

        return $this;
    }

    public function getDateCmd(): ?\DateTimeInterface
    {
        return $this->date_cmd;
    }

    public function setDateCmd(?\DateTimeInterface $date_cmd): self
    {
        $this->date_cmd = $date_cmd;

        return $this;
    }

    public function getPrixTotalLiv(): ?float
    {
        return $this->prix_total_liv;
    }

    public function setPrixTotalLiv(float $prix_total_liv): self
    {
        $this->prix_total_liv = $prix_total_liv;

        return $this;
    }

    public function getModeDePaiment(): ?string
    {
        return $this->mode_de_paiment;
    }

    public function setModeDePaiment(?string $mode_de_paiment): self
    {
        $this->mode_de_paiment = $mode_de_paiment;

        return $this;
    }

    public function getPasser(): ?Consomateur
    {
        return $this->passer;
    }

    public function setPasser(?Consomateur $passer): self
    {
        $this->passer = $passer;

        return $this;
    }

    /**
     * @return Collection|Plats[]
     */
    public function getContient(): Collection
    {
        return $this->contient;
    }

    public function addContient(Plats $contient): self
    {
        if (!$this->contient->contains($contient)) {
            $this->contient[] = $contient;
            $contient->setCommande($this);
        }

        return $this;
    }

    public function removeContient(Plats $contient): self
    {
        if ($this->contient->removeElement($contient)) {
            // set the owning side to null (unless already changed)
            if ($contient->getCommande() === $this) {
                $contient->setCommande(null);
            }
        }

        return $this;
    }
}
