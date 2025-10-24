<?php

namespace ShopBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ShopBundle\Repository\CartRepository;
use UserBundle\Entity\User;

#[ORM\Entity(repositoryClass: CartRepository::class)]
#[ORM\Table(name: 'shop__cart')]
class Cart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    protected ?int $id;

    #[ORM\Column(type: Types::FLOAT)]
    protected ?float $total = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    protected ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(?float $total): Cart
    {
        $this->total = $total;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): Cart
    {
        $this->user = $user;
        return $this;
    }

}
