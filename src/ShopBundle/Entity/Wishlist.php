<?php

namespace ShopBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ShopBundle\Repository\WishlistRepository;
use UserBundle\Entity\User;

#[ORM\Entity(repositoryClass: WishlistRepository::class)]
#[ORM\Table(name: 'shop__wishlist')]
class Wishlist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    protected ?int $id;

    #[ORM\ManyToOne(targetEntity: User::class)]
    protected ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Product::class)]
    protected ?Product $product = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): Wishlist
    {
        $this->user = $user;
        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): Wishlist
    {
        $this->product = $product;
        return $this;
    }
}
