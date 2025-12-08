<?php

namespace ShopBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ShopBundle\Repository\CartRepository;
use Symfony\Component\Serializer\Attribute\Groups;
use UserBundle\Entity\User;

#[ORM\Entity(repositoryClass: CartRepository::class)]
#[ORM\Table(name: 'shop__cart')]
class Cart
{
    const ENTITY_ALIAS = 'cart';

    const NORMALIZER_GROUPS = ['cart.details'];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    #[Groups('cart.details')]
    protected ?int $id;

    #[ORM\Column(type: Types::FLOAT)]
    #[Groups('cart.details')]
    protected ?float $total = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', unique: true, nullable: false)]
    #[Groups('cart.details')]
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
