<?php

namespace App\Entity;

use App\Repository\RestaurantRepository;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=RestaurantRepository::class)
 */
class Restaurant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="bigint")
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Upload your image")
     * @Assert\File(mimeTypes={ "image/png", "image/jpeg" })
     */
    private $image;


    /**
     * @ORM\ManyToMany(targetEntity=Menu::class, mappedBy="resto")
     */
    private $menus;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="author")
     * @ORM\JoinColumn(nullable=true)
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $specialite;


    /**
     * @ORM\OneToOne(targetEntity=Emplacement::class, inversedBy="restaurant", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="adresse_resto", referencedColumnName="id_emp",nullable=true)
     */
    private $adresse_resto;

    /**
     * @ORM\OneToMany(targetEntity=Livreur::class, mappedBy="opere")
     */
    private $livreurs;


    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->menus = new ArrayCollection();
        $this->adresse = new ArrayCollection();
        $this->livreurs = new ArrayCollection();
    }

    /**
     * Permet d'initialiser le slug
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     * @return void
     */
    public function initializeSlug() {
        if(empty($this->libelle)){
            $slugify = new Slugify();
            $this->libelle = $slugify->slugify($this->libelle);
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }


    /**
     * @return Collection|Menu[]
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
            $menu->setResto($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            // set the owning side to null (unless already changed)
            if ($menu->getResto() === $this) {
                $menu->setResto(null);
            }
        }

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(?string $specialite): self
    {
        $this->specialite = $specialite;

        return $this;
    }

    /**
     * @return Collection|emplacement[]
     */
    public function getAdresse(): Collection
    {
        return $this->adresse;
    }

    public function addAdresse(emplacement $adresse): self
    {
        if (!$this->adresse->contains($adresse)) {
            $this->adresse[] = $adresse;
            $adresse->setEmplacement($this);
        }

        return $this;
    }

    public function removeAdresse(emplacement $adresse): self
    {
        if ($this->adresse->removeElement($adresse)) {
            // set the owning side to null (unless already changed)
            if ($adresse->getEmplacement() === $this) {
                $adresse->setEmplacement(null);
            }
        }

        return $this;
    }

    public function getAdresseResto(): ?emplacement
    {
        return $this->adresse_resto;
    }

    public function setAdresseResto(emplacement $adresse_resto): self
    {
        $this->adresse_resto = $adresse_resto;

        return $this;
    }

    /**
     * @return Collection|Livreur[]
     */
    public function getLivreurs(): Collection
    {
        return $this->livreurs;
    }

    public function addLivreur(Livreur $livreur): self
    {
        if (!$this->livreurs->contains($livreur)) {
            $this->livreurs[] = $livreur;
            $livreur->setOpere($this);
        }

        return $this;
    }

    public function removeLivreur(Livreur $livreur): self
    {
        if ($this->livreurs->removeElement($livreur)) {
            // set the owning side to null (unless already changed)
            if ($livreur->getOpere() === $this) {
                $livreur->setOpere(null);
            }
        }

        return $this;
    }




}

