<?php

namespace App\Entity;

use App\Repository\LivraisonRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LivraisonRepository::class)
 */
class Livraison
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $codeEmp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $region;

    /**
     * @ORM\OneToOne(targetEntity=Emplacement::class, inversedBy="livraison", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="id_emp", referencedColumnName="id_emp",nullable=false)
     */
    private $emplacement;

    /**
     * @ORM\OneToOne(targetEntity=Commande::class, cascade={"persist", "remove"})
     */
    private $possede;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeEmp(): ?float
    {
        return $this->codeEmp;
    }

    public function setCodeEmp(float $codeEmp): self
    {
        $this->codeEmp = $codeEmp;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getEmplacement(): ?emplacement
    {
        return $this->emplacement;
    }

    public function setEmplacement(emplacement $emplacement): self
    {
        $this->emplacement = $emplacement;

        return $this;
    }

    public function getPossede(): ?Commande
    {
        return $this->possede;
    }

    public function setPossede(?Commande $possede): self
    {
        $this->possede = $possede;

        return $this;
    }
}
