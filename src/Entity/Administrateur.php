<?php

namespace App\Entity;

use App\Repository\AdministrateurRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdministrateurRepository::class)
 */
class Administrateur extends Personne
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;




    public function getId(): ?int
    {
        return $this->id;
    }

    public function __construct($nom, $prenom, $email, $tel)
    {
        parent::__construct($nom, $prenom, $email, $tel);
    }

    public function addAdministrateur(Administrateur $administrateur): self
    {
        if (!$this->administrateur->contains(administrateur)) {
            $this->administrateur[] = $administrateur;
            $administrateur->addAdministrateur($this);
        }

        return $this;
    }

}
