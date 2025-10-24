<?php

namespace ShopBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ShopBundle\Repository\CategoryRepository;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[Orm\Table(name: 'shop__category')]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    protected ?int $id;

    #[ORM\Column(type: Types::STRING, length: 128)]
    protected ?string $name;

    #[ORM\Column(type: Types::STRING, length: 256)]
    protected ?string $description;

    #[ORM\ManyToMany(targetEntity: Product::class, mappedBy: 'categories')]
    protected ?Collection $products = null;


    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): Category
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): Category
    {
        $this->description = $description;
        return $this;
    }

}
