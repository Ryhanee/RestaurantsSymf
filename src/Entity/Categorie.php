<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
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
    private $libelle_cat;


    /**
     * @ORM\ManyToMany(targetEntity=Menu::class, mappedBy="categorie")
     */
    private $menu;

    public function __construct()
    {
        $this->libelle_plat = new ArrayCollection();
        $this->menu = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleCat(): ?string
    {
        return $this->libelle_cat;
    }

    public function setLibelleCat(string $libelle_cat): self
    {
        $this->libelle_cat = $libelle_cat;

        return $this;
    }

    /**
     * @return Collection|Plats[]
     */
    public function getLibellePlat(): Collection
    {
        return $this->libelle_plat;
    }

    public function addLibellePlat(Plats $libellePlat): self
    {
        if (!$this->libelle_plat->contains($libellePlat)) {
            $this->libelle_plat[] = $libellePlat;
            $libellePlat->setType($this);
        }

        return $this;
    }

    public function removeLibellePlat(Plats $libellePlat): self
    {
        if ($this->libelle_plat->removeElement($libellePlat)) {
            // set the owning side to null (unless already changed)
            if ($libellePlat->getType() === $this) {
                $libellePlat->setType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Menu[]
     */
    public function getCategorie(): Collection
    {
        return $this->categorie;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menu->contains($menu)) {
            $this->menu[] = $menu;
            $menu->addMenu($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menu->removeElement($menu)) {
            $menu->removeCategorie($this);
        }

        return $this;
    }
}
