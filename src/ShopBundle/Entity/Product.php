<?php

namespace ShopBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ShopBundle\Repository\ProductRepository;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[Orm\Table(name: 'shop__product')]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    protected ?int $id;

    #[ORM\Column(type: Types::STRING, length: 128)]
    protected ?string $name;

    #[ORM\Column(type: Types::STRING, length: 256)]
    protected ?string $description;

    #[ORM\Column(type: Types::STRING, length: 256)]
    protected ?string $summary;

    #[ORM\Column(type: Types::FLOAT)]
    protected ?float $price;

    #[ORM\Column(type: Types::INTEGER)]
    protected ?float $stock;

    #[ORM\Column(type: Types::STRING, length: 128)]
    protected ?string $provider;

    #[ORM\Column(type: Types::STRING, length: 128)]
    protected ?string $delivery;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'products')]
    #[ORM\JoinTable(name: 'shop__product_category')]
    protected ?Collection $categories = null;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): Product
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): Product
    {
        $this->description = $description;
        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): Product
    {
        $this->summary = $summary;
        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): Product
    {
        $this->price = $price;
        return $this;
    }

    public function getStock(): ?float
    {
        return $this->stock;
    }

    public function setStock(?float $stock): Product
    {
        $this->stock = $stock;
        return $this;
    }

    public function getProvider(): ?string
    {
        return $this->provider;
    }

    public function setProvider(?string $provider): Product
    {
        $this->provider = $provider;
        return $this;
    }

    public function getDelivery(): ?string
    {
        return $this->delivery;
    }

    public function setDelivery(?string $delivery): Product
    {
        $this->delivery = $delivery;
        return $this;
    }

}
