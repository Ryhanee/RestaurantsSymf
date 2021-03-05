<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 */
class Image
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
    private $url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $caption;

    /**
     * @ORM\ManyToOne(targetEntity=Restaurant::class, inversedBy="images")
     * @ORM\JoinColumn(name="id_resto", referencedColumnName="id",nullable=false)
     */
    private $module;

    /**
     * @ORM\ManyToOne(targetEntity=Test::class, inversedBy="test2")
     * @ORM\JoinColumn(nullable=false)
     */
    private $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getCaption(): ?string
    {
        return $this->caption;
    }

    public function setCaption(string $caption): self
    {
        $this->caption = $caption;

        return $this;
    }

    public function getModule(): ?Restaurant
    {
        return $this->module;
    }

    public function setModule(?Restaurant $module): self
    {
        $this->module = $module;

        return $this;
    }

    public function getName(): ?Test
    {
        return $this->name;
    }

    public function setName(?Test $name): self
    {
        $this->name = $name;

        return $this;
    }
}
